<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracking Servis - {{ $transaction->invoice_number }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .tracking-status { font-weight: 600; font-size: 1.1rem; }
        .badge-custom { padding: 8px 12px; font-size: 0.85rem; border-radius: 8px; }
    </style>
</head>
<body>
<div class="container py-5 max-w-md mx-auto" style="max-width: 600px;">

    <div class="text-center mb-4">
        <h3 class="fw-bold text-primary mb-1"><i class="ti ti-tool"></i> Mandiri Motor</h3>
        <p class="text-muted">Pelacakan Servis Kendaraan</p>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">No. Antrean: {{ $transaction->id }}</h6>
                <span class="text-muted small">{{ $transaction->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <table class="table table-sm table-borderless mb-0">
                <tr><td class="text-muted w-25">Customer</td><td class="fw-semibold">: {{ $transaction->vehicle->customer->name ?? '-' }}</td></tr>
                <tr><td class="text-muted">Kendaraan</td><td class="fw-semibold">: {{ $transaction->vehicle->brand ?? '' }} {{ $transaction->vehicle->model_name ?? '' }}</td></tr>
                <tr><td class="text-muted">No. Polisi</td><td class="fw-semibold">: <span class="badge bg-light text-dark border">{{ $transaction->vehicle->plate_number ?? '-' }}</span></td></tr>
                <tr><td class="text-muted">Keluhan</td><td class="fw-semibold">: {{ $transaction->complaint ?? '-' }}</td></tr>
            </table>
        </div>
    </div>

    <div class="card mb-4 border-start border-4 
        @if($transaction->status == 'selesai') border-success 
        @elseif($transaction->status == 'bisa_diambil') border-info 
        @elseif($transaction->status == 'proses') border-warning 
        @else border-secondary @endif">
        <div class="card-body text-center py-4">
            <h6 class="text-muted mb-2">Status Servis Saat Ini</h6>
            @if($transaction->status == 'antre')
                <div class="text-secondary tracking-status"><i class="ti ti-clock me-1"></i> Antrean Servis Masuk</div>
                <p class="text-muted small mt-2 mb-0">Kendaraan Anda sudah terdaftar dan sedang menunggu antrean.</p>
            @elseif($transaction->status == 'proses')
                <div class="text-warning tracking-status"><i class="ti ti-settings me-1"></i> Sedang Dikerjakan</div>
                <p class="text-muted small mt-2 mb-0">Mekanik kami sedang melakukan perbaikan pada kendaraan Anda.</p>
            @elseif($transaction->status == 'menunggu_sparepart')
                <div class="text-danger tracking-status"><i class="ti ti-box me-1"></i> Menunggu Sparepart</div>
                <p class="text-muted small mt-2 mb-0">Proses perbaikan dihentikan sementara menunggu suku cadang tersedia.</p>
            @elseif($transaction->status == 'bisa_diambil')
                <div class="text-info tracking-status"><i class="ti ti-check me-1"></i> Servis Selesai & Bisa Diambil</div>
                <p class="text-muted small mt-2 mb-0">Kendaraan Anda telah selesai diperbaiki. Silakan menuju meja kasir.</p>
            @elseif($transaction->status == 'selesai')
                <div class="text-success tracking-status"><i class="ti ti-circle-check me-1"></i> Transaksi Selesai</div>
                <p class="text-muted small mt-2 mb-0">Terima kasih telah mempercayakan servis kendaraan Anda kepada kami!</p>
            @else
                <div class="text-dark tracking-status"><i class="ti ti-x me-1"></i> Dibatalkan</div>
            @endif
        </div>
    </div>

    @if(in_array($transaction->status, ['proses', 'menunggu_sparepart', 'bisa_diambil', 'selesai']))
    <div class="card mb-4">
        <div class="card-body">
            <h6 class="fw-bold mb-3 border-bottom pb-2">Rincian Estimasi Biaya</h6>
            @if($transaction->detailServices->count() > 0)
            <p class="fw-semibold text-primary mb-1 small">Jasa Servis</p>
            <table class="table table-sm mb-3">
                <tbody>
                    @foreach($transaction->detailServices as $ds)
                    <tr>
                        <td class="ps-0">{{ $ds->service->name_service ?? 'Jasa' }}</td>
                        <td class="text-end pe-0">Rp {{ number_format($ds->price_at_transaction, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
            @if($transaction->detailSpareparts->count() > 0)
            <p class="fw-semibold text-primary mb-1 small">Penggantian Sparepart</p>
            <table class="table table-sm mb-3">
                <tbody>
                    @foreach($transaction->detailSpareparts as $dp)
                    <tr>
                        <td class="ps-0">{{ $dp->sparepart->name_sparepart ?? 'Sparepart' }} <small class="text-muted">x{{ $dp->quantity }}</small></td>
                        <td class="text-end pe-0">Rp {{ number_format($dp->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
            <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                <span class="fw-bold">Total Biaya:</span>
                <span class="fw-bold text-success fs-5">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
            </div>
            @if($transaction->status == 'selesai')
            <div class="text-end mt-1 text-muted small">
                Telah dibayar: Rp {{ number_format($transaction->money_paid, 0, ',', '.') }}
            </div>
            @endif
        </div>
    </div>
    @endif
    <div class="text-center text-muted small mt-5">
        &copy; {{ date('Y') }} Mandiri Motor. All rights reserved.
    </div>
</div>
</body>
</html>
