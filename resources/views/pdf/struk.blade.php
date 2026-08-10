<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk {{ $sale->invoice_number }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <div class="text-center">
        <h2>APOTEK PINTAR</h2>
        <p>Struk Pembayaran Kasir</p>
    </div>
    <hr>
    <p><strong>No. Nota:</strong> {{ $sale->invoice_number }}</p>
    <p><strong>Tanggal:</strong> {{ $sale->created_at }}</p>
    <p><strong>Pasien:</strong> {{ $sale->patient->name ?? 'Umum' }}</p>

    <table>
        <thead>
            <tr>
                <th>Nama Obat</th>
                <th>Qty</th>
                <th class="text-right">Harga</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->details as $detail)
            <tr>
                <td>{{ $detail->medicine->nama_obat ?? '-' }}</td>
                <td>{{ $detail->quantity }}</td>
                <td class="text-right">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3 class="text-right">Total: Rp {{ number_format($sale->total_price, 0, ',', '.') }}</h3>
</body>
</html>