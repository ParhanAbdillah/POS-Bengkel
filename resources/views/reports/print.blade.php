<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Keuangan</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 14px; color: #333; margin: 0; padding: 20px; background-color: #fff; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h2 { margin: 0; font-size: 24px; text-transform: uppercase; letter-spacing: 1px; }
        .header p { margin: 5px 0 0; color: #555; }
        .info { margin-bottom: 20px; }
        .info p { margin: 5px 0; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table th, table td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        table th { background-color: #f8f9fa; font-weight: bold; text-transform: uppercase; font-size: 12px; }
        .right { text-align: right; }
        .center { text-align: center; }
        .total-row th { background-color: #e9ecef; font-size: 16px; padding: 15px 10px; }
        .footer { margin-top: 40px; text-align: right; }
        .footer .signature { margin-top: 60px; border-top: 1px solid #333; display: inline-block; width: 200px; padding-top: 5px; text-align: center; }
        @media print {
            body { padding: 0; }
            @page { margin: 1cm; size: auto; }
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #007bff; color: #fff; border: none; cursor: pointer; border-radius: 5px;">Cetak Sekarang</button>
    </div>
    <div class="header">
        <h2>MANDIRI MOTOR</h2>
        <p>Jln. Pendidikan, Kec. Ciawi, Kab. Tasikmalaya | Telp: 08978098623</p>
    </div>
    <div class="info">
        <h3 style="margin:0 0 10px 0; text-align:center; text-decoration: underline;">LAPORAN KEUANGAN TRANSAKSI</h3>
        <p>PERIODE: {{ date('d F Y', strtotime($startDate)) }} s/d {{ date('d F Y', strtotime($endDate)) }}</p>
        <p>DICETAK PADA: {{ date('d F Y H:i') }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th style="width: 50px;" class="center">No</th>
                <th style="width: 130px;">Tanggal</th>
                <th style="width: 140px;">No. Invoice</th>
                <th>Jenis Transaksi</th>
                <th>Pelanggan</th>
                <th style="width: 80px;" class="center">Metode</th>
                <th style="width: 120px;" class="right">Total Biaya</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reports as $index => $row)
            <tr>
                <td class="center">{{ $index + 1 }}</td>
                <td>{{ $row->date->format('d/m/Y H:i') }}</td>
                <td>{{ $row->invoice }}</td>
                <td>{{ $row->type }}</td>
                <td>{{ $row->customer }}</td>
                <td class="center">{{ $row->payment_method }}</td>
                <td class="right">Rp {{ number_format($row->total, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="center" style="padding: 20px;">Tidak ada data transaksi pada rentang tanggal tersebut.</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="total-row">
                <th colspan="6" class="right">GRAND TOTAL PENDAPATAN:</th>
                <th class="right">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>
    <div class="footer">
        <p>Surabaya, {{ date('d F Y') }}</p>
        <br>
        <p class="signature">Mengetahui,<br>Pemilik / Admin</p>
    </div>
</body>
</html>
