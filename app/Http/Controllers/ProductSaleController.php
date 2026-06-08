<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductSale;
use App\Models\ProductSaleDetail;
use App\Models\Sparepart;
use Illuminate\Support\Facades\DB;

class ProductSaleController extends Controller
{
    public function index()
    {
        $sales = ProductSale::latest()->get();
        return view('product_sales.index', compact('sales'));
    }

    public function create()
    {
        $spareparts = Sparepart::where('stock_sparepart', '>', 0)->get();
        return view('product_sales.create', compact('spareparts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'spareparts' => 'required|array',
            'quantities' => 'required|array',
            'payment_method' => 'required',
            'money_paid' => 'required|numeric'
        ]);

        DB::beginTransaction();
        try {
            // Generate Invoice
            $lastSale = ProductSale::orderBy('id', 'desc')->first();
            $nextId = $lastSale ? $lastSale->id + 1 : 1;
            $invoiceNumber = 'INV-PRD-' . date('Ymd') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

            // Create Sale
            $sale = ProductSale::create([
                'invoice_number' => $invoiceNumber,
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'payment_method' => $request->payment_method,
                'money_paid' => $request->money_paid,
                'money_change' => 0, // Will update below
                'grand_total' => 0   // Will update below
            ]);

            $grandTotal = 0;

            foreach ($request->spareparts as $key => $sparepart_id) {
                $qty = $request->quantities[$key];
                $sparepart = Sparepart::find($sparepart_id);
                
                if ($sparepart && $qty > 0) {
                    if ($sparepart->stock_sparepart < $qty) {
                        throw new \Exception("Stok {$sparepart->name_sparepart} tidak mencukupi.");
                    }

                    $price = $sparepart->selling_price;
                    $subtotal = $price * $qty;

                    ProductSaleDetail::create([
                        'product_sale_id' => $sale->id,
                        'sparepart_id' => $sparepart->id,
                        'quantity' => $qty,
                        'price' => $price,
                        'subtotal' => $subtotal
                    ]);

                    $sparepart->stock_sparepart -= $qty;
                    $sparepart->save();

                    $grandTotal += $subtotal;
                }
            }

            if ($request->money_paid < $grandTotal) {
                throw new \Exception("Uang bayar kurang dari total tagihan.");
            }

            $sale->update([
                'grand_total' => $grandTotal,
                'money_change' => $request->money_paid - $grandTotal
            ]);

            DB::commit();
            return redirect()->route('product-sales.print', $sale->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(string $id)
    {
        $sale = ProductSale::with('details.sparepart')->findOrFail($id);
        return view('product_sales.show', compact('sale'));
    }

    public function print(string $id)
    {
        $sale = ProductSale::with('details.sparepart')->findOrFail($id);
        return view('product_sales.print', compact('sale'));
    }

    public function destroy(string $id)
    {
        $sale = ProductSale::findOrFail($id);
        // Return stock
        foreach($sale->details as $d) {
            $sp = Sparepart::find($d->sparepart_id);
            if($sp) {
                $sp->stock_sparepart += $d->quantity;
                $sp->save();
            }
        }
        $sale->delete();
        return redirect()->route('product-sales.index')->with('success', 'Penjualan dibatalkan & stok dikembalikan.');
    }
}
