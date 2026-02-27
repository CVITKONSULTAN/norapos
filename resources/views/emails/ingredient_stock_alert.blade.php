<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; color: #333; }
        .header { background: #e74c3c; color: #fff; padding: 15px; text-align: center; }
        .content { padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f5f5f5; }
        .minus { color: #e74c3c; font-weight: bold; }
        .footer { padding: 15px; color: #999; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>⚠️ Peringatan Stok Bahan Minus</h2>
    </div>
    <div class="content">
        <p>Halo <strong>{{ $admin->first_name ?? $admin->username }}</strong>,</p>
        <p>Berikut bahan yang stoknya <strong>minus</strong> setelah transaksi penjualan <strong>{{ $transaction->invoice_no }}</strong>:</p>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Bahan</th>
                    <th>Stok Saat Ini</th>
                </tr>
            </thead>
            <tbody>
                @foreach($alertIngredients as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data['ingredient']->name ?? '-' }}</td>
                    <td class="minus">{{ number_format($data['current_qty'], 2) }} {{ $data['ingredient']->unit->short_name ?? '' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <p style="margin-top: 20px;">Silakan segera lakukan pembelian/restok bahan.</p>
    </div>
    <div class="footer">
        <p>Email ini dikirim otomatis oleh sistem kasir.</p>
    </div>
</body>
</html>
