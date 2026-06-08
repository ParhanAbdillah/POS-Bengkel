<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\ProductSale;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Default to current month if no filter
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $data = $this->getReportData($startDate, $endDate);

        return view('reports.index', array_merge($data, compact('startDate', 'endDate')));
    }

    public function print(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $data = $this->getReportData($startDate, $endDate);

        return view('reports.print', array_merge($data, compact('startDate', 'endDate')));
    }

    private function getReportData($startDate, $endDate)
    {
        // Add 1 day to end date to include the entire end day if it has time
        $end = Carbon::parse($endDate)->endOfDay();

        $services = Transaction::where('status', 'selesai')
            ->whereBetween('created_at', [$startDate, $end])
            ->get()
            ->map(function($item) {
                return (object)[
                    'date' => $item->created_at,
                    'invoice' => $item->invoice_number,
                    'type' => 'Servis & Sparepart',
                    'customer' => $item->vehicle->customer->name ?? '-',
                    'payment_method' => strtoupper($item->payment_method),
                    'total' => $item->grand_total
                ];
            });

        $sales = ProductSale::whereBetween('created_at', [$startDate, $end])
            ->get()
            ->map(function($item) {
                return (object)[
                    'date' => $item->created_at,
                    'invoice' => $item->invoice_number,
                    'type' => 'Penjualan Toko',
                    'customer' => $item->customer_name ?: 'Umum',
                    'payment_method' => strtoupper($item->payment_method),
                    'total' => $item->grand_total
                ];
            });

        $merged = $services->concat($sales)->sortByDesc('date');
        
        $totalRevenue = $merged->sum('total');

        return [
            'reports' => $merged,
            'totalRevenue' => $totalRevenue
        ];
    }
}
