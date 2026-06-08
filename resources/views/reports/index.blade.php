@extends('layouts.app')
@section('title', 'Laporan Keuangan')
@section('content')
<div class="row">

    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('reports.index') }}" method="GET" class="row align-items-end">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <label class="form-label">Dari Tanggal</label>
                        <input type="date" class="form-control" name="start_date" value="{{ $startDate }}" required>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                        <label class="form-label">Sampai Tanggal</label>
                        <input type="date" class="form-control" name="end_date" value="{{ $endDate }}" required>
                    </div>
                    <div class="col-md-4 d-flex">
                        <button type="submit" class="btn btn-primary me-2"><i class="ti ti-filter me-1"></i> Filter</button>
                        <a href="{{ route('reports.print', ['start_date' => $startDate, 'end_date' => $endDate]) }}" target="_blank" class="btn btn-success">
                            <i class="ti ti-printer me-1"></i> Cetak PDF
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center bg-lighter">
                <h5 class="card-title m-0">Data Transaksi ({{ date('d M Y', strtotime($startDate)) }} - {{ date('d M Y', strtotime($endDate)) }})</h5>
                <h4 class="m-0 text-success fw-bold">Total: Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h4>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>No. Invoice</th>
                            <th>Jenis Transaksi</th>
                            <th>Pelanggan</th>
                            <th>Metode</th>
                            <th class="text-end">Total Biaya</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports as $row)
                            <tr>
                                <td>{{ $row->date->format('d/m/Y H:i') }}</td>
                                <td><span class="fw-semibold">{{ $row->invoice }}</span></td>
                                <td>
                                    @if($row->type == 'Penjualan Toko')
                                        <span class="badge bg-label-info"><i class="ti ti-shopping-cart me-1"></i>{{ $row->type }}</span>
                                    @else
                                        <span class="badge bg-label-primary"><i class="ti ti-tool me-1"></i>{{ $row->type }}</span>
                                    @endif
                                </td>
                                <td>{{ $row->customer }}</td>
                                <td>
                                    @if($row->payment_method == 'QRIS')
                                        <span class="badge bg-label-info">QRIS</span>
                                    @else
                                        <span class="badge bg-label-success">CASH</span>
                                    @endif
                                </td>
                                <td class="text-end fw-bold">Rp {{ number_format($row->total, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Tidak ada data transaksi pada rentang tanggal tersebut.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th colspan="5" class="text-end">GRAND TOTAL PENDAPATAN :</th>
                            <th class="text-end text-success fs-5">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
