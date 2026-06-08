<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print No. Antrean - {{ $transaction->invoice_number }}</title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; font-size: 14px; color: #000; background-color: #fff; margin: 0; padding: 20px; }
        .container { width: 350px; margin: 0 auto; border: 1px dashed #000; padding: 15px; }
        .header { text-align: center; margin-bottom: 10px; border-bottom: 1px dashed #000; padding-bottom: 10px; }
        .header h3 { margin: 0; font-size: 18px; text-transform: uppercase; }
        .header p { margin: 5px 0 0; font-size: 12px; }
        .content { margin-bottom: 10px; }
        .content p { margin: 5px 0; display: flex; justify-content: space-between; }
        .content p span:first-child { font-weight: bold; }
        .footer { text-align: center; border-top: 1px dashed #000; padding-top: 10px; font-size: 12px; margin-top: 10px; }
        .antrean-box { text-align: center; border: 2px solid #000; padding: 10px; margin: 10px 0; font-size: 32px; font-weight: bold; }
        .qr-box { text-align: center; margin: 15px 0; }
        .qr-box img { width: 120px; height: 120px; }
        .qr-box p { font-size: 10px; margin-top: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 12px; }
        table th { text-align: left; border-bottom: 1px dashed #000; padding-bottom: 5px; }
        table td { padding: 5px 0; }
        .right { text-align: right; }
        .total-row { font-weight: bold; border-top: 1px dashed #000; }
        @media print {
            body { padding: 0; }
            .container { border: none; width: 100%; max-width: 350px; }
            @page { margin: 0; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="container">
        <div class="header">
            <h3>Mandiri Motor</h3>
            <p>Jln. Pendidikan, Kec. Ciawi, Kab. Tasikmalaya<br>Telp: 08978098623</p>
        </div>
        <div class="content">
            <h4 style="text-align: center; margin: 5px 0;">{{ $transaction->status == 'selesai' ? 'NOTA PEMBAYARAN' : 'TANDA TERIMA SERVIS' }}</h4>
            <div class="antrean-box">
                {{ $transaction->id }}
            </div>
            <p><span>No. Invoice:</span> <span>{{ $transaction->invoice_number }}</span></p>
            <p><span>Tanggal:</span> <span>{{ $transaction->created_at->format('d M Y H:i') }}</span></p>
            <p><span>Customer:</span> <span>{{ $transaction->vehicle->customer->name ?? '-' }}</span></p>
            <p><span>Kendaraan:</span> <span>{{ $transaction->vehicle->plate_number ?? '-' }} - {{ $transaction->vehicle->model_name ?? '' }}</span></p>
        </div>
        @if($transaction->detailServices->count() > 0 || $transaction->detailSpareparts->count() > 0)
        <div class="content" style="border-top: 1px dashed #000; padding-top: 10px;">
            <table>
                <thead>
                    <tr>
                        <th>Deskripsi</th>
                        <th class="right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaction->detailServices as $ds)
                    <tr>
                        <td>[JASA] {{ $ds->service->name_service }}</td>
                        <td class="right">{{ number_format($ds->price_at_transaction, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                    @foreach($transaction->detailSpareparts as $dp)
                    <tr>
                        <td>{{ $dp->sparepart->name_sparepart }} (x{{ $dp->quantity }})</td>
                        <td class="right">{{ number_format($dp->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                    <tr class="total-row">
                        <td style="padding-top:10px;">TOTAL BIAYA:</td>
                        <td class="right" style="padding-top:10px;">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</td>
                    </tr>
                    @if($transaction->status == 'selesai')
                    <tr>
                        <td>METODE BAYAR:</td>
                        <td class="right">{{ strtoupper($transaction->payment_method ?? 'CASH') }}</td>
                    </tr>
                    <tr>
                        <td>DIBAYAR:</td>
                        <td class="right">Rp {{ number_format($transaction->money_paid, 0, ',', '.') }}</td>
                    </tr>
                    @if(($transaction->payment_method ?? 'cash') == 'cash')
                    <tr>
                        <td>KEMBALI:</td>
                        <td class="right">Rp {{ number_format($transaction->money_change, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                    @endif
                </tbody>
            </table>
        </div>
        @endif
        <div class="qr-box">
            @php
                $trackingUrl = route('transactions.track', $transaction->invoice_number);
                $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($trackingUrl);
            @endphp
            <img src="{{ $qrUrl }}" alt="QR Code Tracking">
            <p>Scan QR Code di atas menggunakan kamera HP Anda untuk melihat status pengerjaan secara Real-Time.</p>
        </div>
        <div class="footer">
            <p>Simpan struk ini sebagai bukti {{ $transaction->status == 'selesai' ? 'pembayaran sah' : 'pengambilan kendaraan' }}.</p>
            <p>Terima Kasih</p>
        </div>
    </div>
</body>
</html>
