@extends('layouts.app')
@section('title', 'Dashboard')
@push('mystyle')
<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.07);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 15px;
    }
    .glass-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px 0 rgba(31, 38, 135, 0.15);
    }
    .vibrant-blue {
        background: linear-gradient(135deg, #00c6ff 0%, #0072ff 100%);
        color: white;
    }
    .vibrant-green {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
    }
    .vibrant-purple {
        background: linear-gradient(135deg, #8E2DE2 0%, #4A00E0 100%);
        color: white;
    }
    .vibrant-orange {
        background: linear-gradient(135deg, #f12711 0%, #f5af19 100%);
        color: white;
    }
    .stat-icon {
        font-size: 2.5rem;
        opacity: 0.8;
    }
    .stat-title {
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: 0.9;
        margin-bottom: 5px;
    }
    .stat-value {
        font-size: 1.8rem;
        font-weight: bold;
        margin-bottom: 0;
    }
    .table-hover tbody tr {
        transition: all 0.2s ease;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0, 114, 255, 0.05);
        transform: scale(1.01);
    }
</style>
@endpush
@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Beranda /</span> Dashboard Analitik</h4>
    <div class="row">

        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card glass-card vibrant-blue h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-title">Pendapatan Bulan Ini</div>
                        <h3 class="stat-value text-white">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    </div>
                    <div class="stat-icon">
                        <i class="ti ti-wallet"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card glass-card vibrant-purple h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-title">Total Transaksi (Bulan Ini)</div>
                        <h3 class="stat-value text-white">{{ $totalTransactions }} Transaksi</h3>
                    </div>
                    <div class="stat-icon">
                        <i class="ti ti-receipt"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 col-md-12 mb-4">
            <div class="card glass-card h-100">
                <div class="card-header border-bottom d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2"><i class="ti ti-car me-2 text-primary"></i>Status Kendaraan di Bengkel</h5>
                </div>
                <div class="card-body pt-4">
                    <div class="row text-center">
                        <div class="col-3 border-end">
                            <h2 class="text-warning fw-bold mb-1">{{ $antre }}</h2>
                            <span class="text-muted">Antre</span>
                        </div>
                        <div class="col-3 border-end">
                            <h2 class="text-primary fw-bold mb-1">{{ $proses }}</h2>
                            <span class="text-muted">Diproses</span>
                        </div>
                        <div class="col-3 border-end">
                            <h2 class="text-danger fw-bold mb-1">{{ $menungguSparepart }}</h2>
                            <span class="text-muted">Tunggu Part</span>
                        </div>
                        <div class="col-3">
                            <h2 class="text-success fw-bold mb-1">{{ $bisaDiambil }}</h2>
                            <span class="text-muted">Bisa Diambil</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12 mb-4">
            <div class="card glass-card h-100">
                <div class="card-header border-bottom">
                    <h5 class="card-title m-0 me-2"><i class="ti ti-alert-triangle me-2 text-warning"></i>Peringatan Stok</h5>
                </div>
                <div class="card-body p-0" style="max-height: 150px; overflow-y: auto;">
                    @if($lowStockSpareparts->count() > 0)
                        <ul class="list-group list-group-flush">
                            @foreach($lowStockSpareparts as $sp)
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                    <div>
                                        <h6 class="mb-0">{{ $sp->name_sparepart }}</h6>
                                        <small class="text-muted">Min: {{ $sp->min_stock_sparepart }}</small>
                                    </div>
                                    <span class="badge bg-label-danger rounded-pill">Sisa: {{ $sp->stock_sparepart }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="p-4 text-center text-muted">
                            <i class="ti ti-check mb-2 fs-2 text-success"></i><br>
                            Semua stok aman.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card glass-card">
                <div class="card-header border-bottom d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2"><i class="ti ti-history me-2 text-info"></i>5 Transaksi Servis Terakhir</h5>
                    <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-borderless mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Invoice</th>
                                <th>Tanggal</th>
                                <th>Customer</th>
                                <th>Kendaraan</th>
                                <th>Status</th>
                                <th>Total Biaya</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTransactions as $tx)
                                <tr>
                                    <td><span class="fw-semibold text-primary">#{{ $tx->invoice_number }}</span></td>
                                    <td>{{ $tx->created_at->format('d M Y, H:i') }}</td>
                                    <td>{{ $tx->vehicle->customer->name ?? '-' }}</td>
                                    <td>{{ $tx->vehicle->plate_number ?? '-' }}</td>
                                    <td>
                                        @if($tx->status == 'antre') <span class="badge bg-label-warning">Antre</span>
                                        @elseif($tx->status == 'proses') <span class="badge bg-label-primary">Proses</span>
                                        @elseif($tx->status == 'menunggu_sparepart') <span class="badge bg-label-danger">Tunggu Part</span>
                                        @elseif($tx->status == 'bisa_diambil') <span class="badge bg-label-info">Bisa Diambil</span>
                                        @elseif($tx->status == 'selesai') <span class="badge bg-label-success">Selesai</span>
                                        @endif
                                    </td>
                                    <td class="fw-bold">Rp {{ number_format($tx->grand_total, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">Belum ada transaksi servis.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
