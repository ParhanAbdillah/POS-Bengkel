<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\ProductSale;
use App\Models\Sparepart;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Pendapatan Bulan Ini (Servis Selesai + Penjualan Langsung)
        $revenueService = Transaction::where('status', 'selesai')
                                     ->whereMonth('created_at', $currentMonth)
                                     ->whereYear('created_at', $currentYear)
                                     ->sum('grand_total');

        $revenueSales = ProductSale::whereMonth('created_at', $currentMonth)
                                   ->whereYear('created_at', $currentYear)
                                   ->sum('grand_total');
                                   
        $totalRevenue = $revenueService + $revenueSales;

        // Jumlah Transaksi Bulan Ini
        $totalTransactionsService = Transaction::whereMonth('created_at', $currentMonth)
                                               ->whereYear('created_at', $currentYear)
                                               ->count();
        $totalTransactionsSales = ProductSale::whereMonth('created_at', $currentMonth)
                                             ->whereYear('created_at', $currentYear)
                                             ->count();
                                             
        $totalTransactions = $totalTransactionsService + $totalTransactionsSales;

        // Status Kendaraan Servis
        $statusCounts = Transaction::selectRaw('status, count(*) as total')
                                   ->groupBy('status')
                                   ->pluck('total', 'status')->toArray();

        $antre = $statusCounts['antre'] ?? 0;
        $proses = $statusCounts['proses'] ?? 0;
        $menungguSparepart = $statusCounts['menunggu_sparepart'] ?? 0;
        $bisaDiambil = $statusCounts['bisa_diambil'] ?? 0;
        $selesai = $statusCounts['selesai'] ?? 0;
        
        $kendaraanAktif = $antre + $proses + $menungguSparepart + $bisaDiambil;

        // Peringatan Stok Tipis
        $lowStockSpareparts = Sparepart::whereColumn('stock_sparepart', '<=', 'min_stock_sparepart')
                                       ->orderBy('stock_sparepart', 'asc')
                                       ->get();

        // 5 Transaksi Servis Terakhir
        $recentTransactions = Transaction::with('vehicle.customer')
                                         ->orderBy('created_at', 'desc')
                                         ->take(5)
                                         ->get();

        return view('dashboard.index', compact(
            'totalRevenue', 
            'totalTransactions',
            'kendaraanAktif',
            'antre',
            'proses',
            'menungguSparepart',
            'bisaDiambil',
            'selesai',
            'lowStockSpareparts',
            'recentTransactions'
        ));
    }
}
