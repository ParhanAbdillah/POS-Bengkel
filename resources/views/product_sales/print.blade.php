<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Penjualan - {{ $sale->invoice_number }}</title>
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
            <h4 style="text-align: center; margin: 5px 0;">NOTA PEMBELIAN</h4>
            <p><span>No. Invoice:</span> <span>{{ $sale->invoice_number }}</span></p>
            <p><span>Tanggal:</span> <span>{{ $sale->created_at->format('d M Y H:i') }}</span></p>
            <p><span>Customer:</span> <span>{{ $sale->customer_name ?: 'Umum' }}</span></p>
        </div>
        <div class="content" style="border-top: 1px dashed #000; padding-top: 10px;">
            <table>
                <thead>
                    <tr>
                        <th>Deskripsi</th>
                        <th class="right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sale->details as $dp)
                    <tr>
                        <td>{{ $dp->sparepart->name_sparepart }} (x{{ $dp->quantity }})<br><small>Rp {{ number_format($dp->price, 0, ',', '.') }}</small></td>
                        <td class="right">{{ number_format($dp->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                    <tr class="total-row">
                        <td style="padding-top:10px;">TOTAL:</td>
                        <td class="right" style="padding-top:10px;">Rp {{ number_format($sale->grand_total, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>METODE BAYAR:</td>
                        <td class="right">{{ strtoupper($sale->payment_method ?? 'CASH') }}</td>
                    </tr>
                    <tr>
                        <td>DIBAYAR:</td>
                        <td class="right">Rp {{ number_format($sale->money_paid, 0, ',', '.') }}</td>
                    </tr>
                    @if($sale->payment_method == 'cash')
                    <tr>
                        <td>KEMBALI:</td>
                        <td class="right">Rp {{ number_format($sale->money_change, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="footer">
            <p>Barang yang sudah dibeli tidak dapat ditukar atau dikembalikan.</p>
            <p>Terima Kasih</p>
        </div>
    </div>
</body>
</html>
