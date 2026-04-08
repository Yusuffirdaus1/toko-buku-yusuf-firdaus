<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->id }} - Toko Buku Yusuf Firdaus</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background: #fdfdfd;
        }
        .invoice-container {
            max-width: 800px;
            margin: 40px auto;
            background: #fff;
            padding: 50px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border-top: 5px solid #4f46e5;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .company-details h1 {
            margin: 0;
            font-size: 24px;
            color: #4f46e5;
            letter-spacing: -0.5px;
        }
        .company-details p {
            margin: 3px 0;
            color: #64748b;
            font-size: 14px;
        }
        .invoice-details {
            text-align: right;
        }
        .invoice-details h2 {
            margin: 0;
            font-size: 28px;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .invoice-details p {
            margin: 3px 0;
            font-size: 14px;
            color: #64748b;
        }
        .customer-shipping {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
        }
        .billing-to, .shipping-to {
            width: 48%;
        }
        h3 {
            font-size: 15px;
            text-transform: uppercase;
            color: #94a3b8;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 5px;
            margin-bottom: 15px;
            letter-spacing: 0.5px;
        }
        .customer-shipping p {
            margin: 3px 0;
            font-size: 14px;
        }
        .customer-shipping strong {
            color: #0f172a;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
            font-size: 14px;
        }
        th {
            background-color: #f8fafc;
            color: #475569;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }
        td.amount, th.amount {
            text-align: right;
        }
        .totals {
            width: 50%;
            float: right;
        }
        .totals table th, .totals table td {
            border: none;
            padding: 8px 15px;
        }
        .totals table tr.grand-total {
            border-top: 2px solid #e2e8f0;
        }
        .totals table tr.grand-total td, .totals table tr.grand-total th {
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
            padding-top: 15px;
        }
        .clear {
            clear: both;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            color: #94a3b8;
            font-size: 14px;
            border-top: 1px solid #e2e8f0;
            padding-top: 20px;
        }
        
        @media print {
            body {
                background: #fff;
            }
            .invoice-container {
                box-shadow: none;
                margin: 0;
                padding: 20px;
                max-width: 100%;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="invoice-container">
        <div class="header">
            <div class="company-details">
                <h1>Toko Buku Yusuf Firdaus</h1>
                <p>Jl. Literasi No. 99, Jakarta</p>
                <p>Email: tokobuku@example.com</p>
                <p>Telepon: 088289188861</p>
            </div>
            <div class="invoice-details">
                <h2>INVOICE</h2>
                <p><strong>INVOICE #</strong> INV-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
                <p><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y') }}</p>
                <p><strong>Status:</strong> <span style="text-transform: uppercase;">{{ $order->status }}</span></p>
            </div>
        </div>

        <div class="customer-shipping">
            <div class="billing-to">
                <h3>Tagihan Kepada:</h3>
                <p><strong>{{ $order->user->name }}</strong></p>
                <p>{{ $order->user->email }}</p>
                <p>{{ $order->phone }}</p>
            </div>
            <div class="shipping-to">
                <h3>Kirim Ke:</h3>
                <p><strong>{{ $order->user->name }}</strong></p>
                <p>{{ $order->address }}</p>
                <p><strong>Kurir:</strong> {{ $order->shipping_courier ?: 'Belum di update' }}</p>
                <p><strong>Resi:</strong> {{ $order->tracking_number ?: '-' }}</p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Deskripsi Item</th>
                    <th>Harga Satuan</th>
                    <th style="text-align: center;">Kuantitas</th>
                    <th class="amount">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>
                        <strong>{{ $item->book->title }}</strong><br>
                        <span style="font-size: 12px; color: #64748b;">Oleh: {{ $item->book->author }}</span>
                    </td>
                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                    <td class="amount">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <table>
                <tr>
                    <th>Subtotal</th>
                    <td class="amount">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Metode Pembayaran</th>
                    <td class="amount" style="text-transform: uppercase;">{{ $order->payment_method }}</td>
                </tr>
                <tr class="grand-total">
                    <th>Total Pembayaran</th>
                    <td class="amount">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
        <div class="clear"></div>

        <div class="footer">
            <p>Terima kasih telah berbelanja di Toko Buku Yusuf Firdaus!</p>
            <p style="font-size: 12px; margin-top: 5px;">Invoice ini sah dan diproses oleh komputer, tidak memerlukan tanda tangan basah.</p>
        </div>
    </div>
</body>
</html>
