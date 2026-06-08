<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionDetailService;
use App\Models\TransactionDetailSparepart;
use App\Models\Customer;
use App\Models\Mechanics;
use App\Models\Services;
use App\Models\Sparepart;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['vehicle.customer'])
            ->where('status', '!=', 'selesai')
            ->latest()
            ->get();
        return view('transactions.index', compact('transactions'));
    }

    public function returns()
    {
        // Only show transactions that are ready to be taken or completed
        $transactions = Transaction::with(['vehicle.customer'])
            ->whereIn('status', ['bisa_diambil', 'selesai'])
            ->latest()
            ->get();
            
        return view('transactions.returns', compact('transactions'));
    }

    public function track($invoice_number)
    {
        $transaction = Transaction::with(['vehicle.customer', 'detailServices.service', 'detailSpareparts.sparepart', 'mechanic'])
            ->where('invoice_number', $invoice_number)
            ->firstOrFail();
            
        return view('transactions.track', compact('transaction'));
    }

    public function create()
    {
        $transactions = Transaction::with(['vehicle.customer', 'mechanic'])
            ->where('status', '!=', 'selesai')
            ->latest()
            ->get();
        $vehicles = \App\Models\Vehicle::with('customer')->orderBy('created_at', 'desc')->get();
        $customers = \App\Models\Customer::orderBy('name', 'asc')->get();
        $mechanics = \App\Models\Mechanics::all();
        // Fallback or static list if categories table doesn't exist
        $serviceCategories = ['Servis Ringan', 'Servis Besar', 'Ganti Oli', 'Ganti Sparepart'];
        return view('transactions.create', compact('transactions', 'vehicles', 'customers', 'mechanics', 'serviceCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'service_category' => 'required|string',
            'complaint' => 'required|string',
            'description' => 'required|string',
            'vehicle_condition' => 'required|string',
            'current_km' => 'nullable|numeric',
            'service_type' => 'required|string',
            'dp' => 'nullable|numeric'
        ]);

        $prefix = 'INV-' . date('Ymd') . '-';
        $lastTransaction = Transaction::where('invoice_number', 'like', $prefix . '%')
            ->orderBy('id', 'desc')->first();
        $nextNumber = 1;
        if ($lastTransaction) {
            $lastNumber = (int) substr($lastTransaction->invoice_number, -4);
            $nextNumber = $lastNumber + 1;
        }
        $invoiceNumber = $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        $transaction = Transaction::create([
            'invoice_number' => $invoiceNumber,
            'vehicle_id' => $request->vehicle_id,
            'service_category' => $request->service_category,
            'complaint' => $request->complaint,
            'description' => $request->description,
            'vehicle_condition' => $request->vehicle_condition,
            'current_km' => $request->current_km,
            'service_type' => $request->service_type,
            'dp' => $request->dp ?? 0,
            'status' => 'antre'
        ]);

        return redirect()->back()->with('new_transaction', [
            'invoice_number' => $invoiceNumber,
            'id' => $transaction->id
        ])->with('success', 'Transaksi Servis berhasil didaftarkan.');
    }

    public function edit(Transaction $transaction)
    {
        $services = Services::all();
        $spareparts = Sparepart::where('stock_sparepart', '>', 0)->get();
        $mechanics = \App\Models\Mechanics::all();
        // Load relationships
        $transaction->load(['detailServices.service', 'detailServices.mechanic', 'detailSpareparts', 'vehicle.customer', 'mechanic']);
        
        return view('transactions.edit', compact('transaction', 'services', 'spareparts', 'mechanics'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'status' => 'required|in:antre,proses,menunggu_sparepart,bisa_diambil,selesai,cancel'
        ]);

        DB::beginTransaction();
        try {
            $totalServicePrice = 0;
            $totalSparepartPrice = 0;

            // 1. Process Services
            $transaction->detailServices()->delete();
            if ($request->has('services')) {
                foreach ($request->services as $key => $service_id) {
                    $service = Services::find($service_id);
                    $mechanic_id = $request->mechanics[$key] ?? null;
                    if ($service) {
                        TransactionDetailService::create([
                            'transaction_id' => $transaction->id,
                            'service_id' => $service->id,
                            'mechanic_id' => $mechanic_id,
                            'price_at_transaction' => $service->price_service
                        ]);
                        $totalServicePrice += $service->price_service;
                    }
                }
            }

            // 2. Process Spareparts
            // Only deduct stock when transitioning to 'selesai'
            $isCheckout = ($request->status == 'selesai' && $transaction->status != 'selesai');

            $transaction->detailSpareparts()->delete();
            if ($request->has('spareparts')) {
                foreach ($request->spareparts as $key => $sparepart_id) {
                    $qty = $request->quantities[$key];
                    $sparepart = Sparepart::find($sparepart_id);
                    
                    if ($sparepart && $qty > 0) {
                        $price = $sparepart->selling_price;
                        $subtotal = $price * $qty;
                        
                        TransactionDetailSparepart::create([
                            'transaction_id' => $transaction->id,
                            'sparepart_id' => $sparepart->id,
                            'quantity' => $qty,
                            'price_at_transaction' => $price,
                            'subtotal' => $subtotal
                        ]);
                        $totalSparepartPrice += $subtotal;

                        if ($isCheckout) {
                            if ($sparepart->stock_sparepart < $qty) {
                                throw new \Exception("Stok {$sparepart->name_sparepart} tidak mencukupi. Sisa stok: {$sparepart->stock_sparepart}");
                            }
                            $sparepart->stock_sparepart -= $qty;
                            $sparepart->save();
                        }
                    }
                }
            }

            $grandTotal = $totalServicePrice + $totalSparepartPrice;

            // 3. Handle Payment
            $moneyPaid = $request->money_paid ?? $transaction->money_paid;
            $moneyChange = 0;

            if ($request->status == 'selesai') {
                $totalSisaBayar = $grandTotal - $transaction->dp;
                if ($moneyPaid < $totalSisaBayar && $totalSisaBayar > 0) {
                    throw new \Exception("Uang bayar tidak mencukupi. Sisa tagihan Rp " . number_format($totalSisaBayar, 0, ',', '.'));
                }
                $moneyChange = $moneyPaid - $totalSisaBayar;
            }

            // Update Transaction
            $transaction->update([
                'total_service_price' => $totalServicePrice,
                'total_sparepart_price' => $totalSparepartPrice,
                'grand_total' => $grandTotal,
                'payment_method' => $request->has('payment_method') ? $request->payment_method : null,
                'money_paid' => $request->status == 'selesai' ? $request->money_paid : 0,
                'money_change' => $request->status == 'selesai' ? $moneyChange : 0,
                'status' => $request->status,
                'vehicle_condition' => $request->vehicle_condition,
                'periodic_service_value' => $request->periodic_service_value,
                'periodic_service_unit' => $request->periodic_service_unit,
                'periodic_service_message' => $request->periodic_service_message,
                'technician_notes' => $request->technician_notes,
            ]);

            DB::commit();
            return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui transaksi: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus.');
    }

    public function print(Transaction $transaction)
    {
        $transaction->load(['vehicle.customer']);
        return view('transactions.print', compact('transaction'));
    }

    public function queueInfo()
    {
        return view('transactions.queue');
    }

    public function queueData()
    {
        $today = Carbon::today();
        
        $transactions = Transaction::with(['vehicle'])
            ->whereDate('created_at', $today)
            ->whereIn('status', ['antre', 'proses', 'bisa_diambil'])
            ->orderBy('updated_at', 'desc')
            ->get();
            
        $antre = $transactions->where('status', 'antre')->values();
        $proses = $transactions->where('status', 'proses')->values();
        $selesai = $transactions->where('status', 'bisa_diambil')->values();

        return response()->json([
            'antre' => $antre,
            'proses' => $proses,
            'selesai' => $selesai
        ]);
    }
}
