<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->id }} - Toko Buku Yusuf Firdaus</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f0f2f5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 30px 15px;
        }

        /* ─── Tombol Aksi Atas ───────────────────────────────────── */
        .action-bar {
            width: 100%;
            max-width: 480px;
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .action-bar .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 20px;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-back {
            background: #fff;
            color: #475569;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
        }
        .btn-back:hover { background: #f1f5f9; }

        .btn-print {
            background: linear-gradient(135deg, #4f46e5, #3730a3);
            color: #fff;
            box-shadow: 0 4px 15px rgba(79,70,229,0.3);
            margin-left: auto;
        }
        .btn-print:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79,70,229,0.4);
        }

        .btn-download {
            background: linear-gradient(135deg, #10b981, #059669);
            color: #fff;
            box-shadow: 0 4px 15px rgba(16,185,129,0.3);
        }
        .btn-download:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16,185,129,0.4);
        }

        /* ─── Struk/Receipt ─────────────────────────────────────── */
        .receipt {
            width: 100%;
            max-width: 480px;
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 8px 40px rgba(0,0,0,0.08);
            overflow: hidden;
            position: relative;
        }

        /* Header gradient */
        .receipt-header {
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 50%, #818cf8 100%);
            padding: 35px 30px 50px;
            text-align: center;
            position: relative;
        }

        .receipt-header::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            height: 30px;
            background: #fff;
            border-radius: 24px 24px 0 0;
        }

        .store-name {
            color: rgba(255,255,255,0.9);
            font-size: 0.8rem;
            font-weight: 500;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .receipt-title {
            color: #fff;
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .invoice-number {
            color: rgba(255,255,255,0.7);
            font-size: 0.82rem;
            font-weight: 400;
        }

        /* Success icon */
        .success-icon {
            width: 70px;
            height: 70px;
            background: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: -55px auto 20px;
            position: relative;
            z-index: 2;
            box-shadow: 0 6px 25px rgba(16,185,129,0.25);
        }

        .success-icon i {
            font-size: 2.2rem;
            color: #10b981;
        }

        /* Status badge */
        .status-section {
            text-align: center;
            padding: 0 30px 20px;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 18px;
            border-radius: 50px;
            font-size: 0.78rem;
            font-weight: 600;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-confirmed {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-shipped {
            background: #e0e7ff;
            color: #3730a3;
        }

        .status-completed {
            background: #dcfce7;
            color: #166534;
        }

        .status-cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-date {
            font-size: 0.75rem;
            color: #94a3b8;
            margin-top: 6px;
        }

        /* Total Besar */
        .total-highlight {
            text-align: center;
            padding: 15px 30px 25px;
        }

        .total-label {
            font-size: 0.78rem;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .total-amount {
            font-size: 2rem;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -1px;
        }

        /* Divider garis putus-putus */
        .dashed-divider {
            border: none;
            border-top: 2px dashed #e2e8f0;
            margin: 0 25px;
        }

        /* Section body */
        .receipt-body {
            padding: 25px 30px;
        }

        .section-label {
            font-size: 0.72rem;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        /* Info row */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-bottom: 25px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-item .label {
            font-size: 0.72rem;
            color: #94a3b8;
            margin-bottom: 2px;
        }

        .info-item .value {
            font-size: 0.85rem;
            color: #1e293b;
            font-weight: 600;
        }

        /* Item list */
        .item-list {
            margin-bottom: 20px;
        }

        .item-row {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .item-row:last-child {
            border-bottom: none;
        }

        .item-cover {
            width: 45px;
            height: 58px;
            border-radius: 8px;
            object-fit: cover;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            flex-shrink: 0;
        }

        .item-info {
            flex: 1;
            min-width: 0;
        }

        .item-title {
            font-size: 0.82rem;
            font-weight: 600;
            color: #1e293b;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .item-author {
            font-size: 0.72rem;
            color: #94a3b8;
        }

        .item-qty {
            font-size: 0.72rem;
            color: #64748b;
            margin-top: 2px;
        }

        .item-subtotal {
            font-size: 0.85rem;
            font-weight: 700;
            color: #4f46e5;
            white-space: nowrap;
            align-self: center;
        }

        /* Ringkasan harga */
        .price-summary {
            margin-top: 5px;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            font-size: 0.82rem;
        }

        .price-row .price-label {
            color: #64748b;
        }

        .price-row .price-value {
            color: #1e293b;
            font-weight: 600;
        }

        .price-row.total-row {
            border-top: 2px solid #e2e8f0;
            margin-top: 8px;
            padding-top: 14px;
        }

        .price-row.total-row .price-label {
            font-weight: 700;
            color: #0f172a;
            font-size: 0.9rem;
        }

        .price-row.total-row .price-value {
            font-weight: 700;
            color: #4f46e5;
            font-size: 1.1rem;
        }

        /* Footer struk */
        .receipt-footer {
            background: #f8fafc;
            padding: 20px 30px;
            text-align: center;
            border-top: 1px solid #f1f5f9;
        }

        .footer-thankyou {
            font-size: 0.88rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 4px;
        }

        .footer-sub {
            font-size: 0.72rem;
            color: #94a3b8;
            line-height: 1.5;
        }

        .footer-legal {
            font-size: 0.65rem;
            color: #cbd5e1;
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px dashed #e2e8f0;
        }

        /* Zigzag bottom edge effect */
        .zigzag-edge {
            width: 100%;
            max-width: 480px;
            height: 15px;
            background: linear-gradient(-45deg, #f0f2f5 8px, transparent 0) 0 0,
                        linear-gradient(45deg, #f0f2f5 8px, transparent 0) 0 0;
            background-position: left bottom;
            background-repeat: repeat-x;
            background-size: 16px 15px;
            background-color: #fff;
            margin-top: -1px;
        }

        /* Animasi checkmark */
        @keyframes scaleIn {
            0% { transform: scale(0); opacity: 0; }
            50% { transform: scale(1.15); }
            100% { transform: scale(1); opacity: 1; }
        }

        .success-icon {
            animation: scaleIn 0.5s ease-out;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .receipt {
            animation: fadeInUp 0.6s ease-out;
        }

        /* ─── Print Styles ──────────────────────────────────────── */
        @media print {
            body {
                background: #fff !important;
                padding: 0 !important;
            }

            .action-bar {
                display: none !important;
            }

            .receipt {
                box-shadow: none !important;
                border-radius: 0 !important;
                max-width: 100% !important;
                animation: none !important;
            }

            .success-icon {
                animation: none !important;
            }

            .zigzag-edge {
                display: none !important;
            }

            .receipt-header {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }

        /* Responsive */
        @media (max-width: 520px) {
            body { padding: 15px 10px; }
            .receipt-header { padding: 25px 20px 45px; }
            .receipt-body { padding: 20px; }
            .receipt-footer { padding: 15px 20px; }
            .info-grid { grid-template-columns: 1fr; gap: 10px; }
            .total-amount { font-size: 1.6rem; }
        }
    </style>
</head>
<body>

    {{-- Tombol aksi (tidak muncul saat print) --}}
    <div class="action-bar">
        <a href="{{ route('orders.show', $order) }}" class="btn btn-back">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <button class="btn btn-print" onclick="window.print()">
            <i class="bi bi-printer"></i> Cetak
        </button>
    </div>

    {{-- Struk/Receipt --}}
    <div class="receipt">
        {{-- Header --}}
        <div class="receipt-header">
            <p class="store-name"><i class="bi bi-book-half"></i> Toko Buku Yusuf Firdaus</p>
            <h1 class="receipt-title">Invoice Pembayaran</h1>
            <p class="invoice-number">INV-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
        </div>

        {{-- Success Icon --}}
        <div class="success-icon">
            @if($order->status === 'cancelled')
                <i class="bi bi-x-lg" style="color: #ef4444;"></i>
            @elseif(in_array($order->status, ['confirmed', 'shipped', 'completed']))
                <i class="bi bi-check-lg"></i>
            @else
                <i class="bi bi-clock" style="color: #f59e0b;"></i>
            @endif
        </div>

        {{-- Status --}}
        <div class="status-section">
            @php
                $statusClass = match($order->status) {
                    'pending' => 'status-pending',
                    'confirmed' => 'status-confirmed',
                    'shipped' => 'status-shipped',
                    'completed' => 'status-completed',
                    'cancelled' => 'status-cancelled',
                    default => 'status-pending',
                };
                $statusText = match($order->status) {
                    'pending' => 'Menunggu Pembayaran',
                    'confirmed' => 'Pembayaran Dikonfirmasi',
                    'shipped' => 'Sedang Dikirim',
                    'completed' => 'Transaksi Selesai',
                    'cancelled' => 'Dibatalkan',
                    default => $order->status,
                };
            @endphp
            <span class="status-badge {{ $statusClass }}">
                <i class="bi bi-circle-fill" style="font-size: 6px;"></i>
                {{ $statusText }}
            </span>
            <p class="status-date">{{ $order->created_at->translatedFormat('d F Y • H:i') }} WIB</p>
        </div>

        {{-- Total Besar --}}
        <div class="total-highlight">
            <p class="total-label">Total Pembayaran</p>
            <p class="total-amount">{{ $order->formatted_total }}</p>
        </div>

        <hr class="dashed-divider">

        {{-- Detail Transaksi --}}
        <div class="receipt-body">
            <p class="section-label">Detail Transaksi</p>

            <div class="info-grid">
                <div class="info-item">
                    <span class="label">Pembeli</span>
                    <span class="value">{{ $order->user->name }}</span>
                </div>
                <div class="info-item">
                    <span class="label">No. Telepon</span>
                    <span class="value">{{ $order->phone }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Metode Bayar</span>
                    <span class="value">{{ strtoupper($order->payment_method) }}</span>
                </div>
                @if($order->payment_method === 'QRIS')
                    <div class="info-item">
                        <span class="label">Kurir</span>
                        <span class="value">{{ $order->shipping_courier ?: '-' }}</span>
                    </div>
                    @if($order->tracking_number)
                    <div class="info-item">
                        <span class="label">No. Resi</span>
                        <span class="value">{{ $order->tracking_number }}</span>
                    </div>
                    @endif
                @endif
                <div class="info-item">
                    <span class="label">Alamat / Lokasi</span>
                    <span class="value">{{ $order->address }}</span>
                </div>
            </div>

            <hr class="dashed-divider" style="margin: 0 0 20px 0;">

            {{-- Item Pesanan --}}
            <p class="section-label">Item Pesanan ({{ $order->items->count() }} item)</p>

            <div class="item-list">
                @foreach($order->items as $item)
                <div class="item-row">
                    <img src="{{ $item->book->cover_url }}" alt="{{ $item->book->title }}" class="item-cover">
                    <div class="item-info">
                        <p class="item-title">{{ $item->book->title }}</p>
                        <p class="item-author">{{ $item->book->author }}</p>
                        <p class="item-qty">{{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                    </div>
                    <span class="item-subtotal">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                </div>
                @endforeach
            </div>

            {{-- Ringkasan Harga --}}
            <div class="price-summary">
                <div class="price-row">
                    <span class="price-label">Subtotal ({{ $order->items->sum('quantity') }} item)</span>
                    <span class="price-value">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
                @if($order->payment_method === 'QRIS')
                <div class="price-row">
                    <span class="price-label">Ongkos Kirim</span>
                    <span class="price-value" style="color: #10b981;">Gratis</span>
                </div>
                @endif
                <div class="price-row total-row">
                    <span class="price-label">Total Pembayaran</span>
                    <span class="price-value">{{ $order->formatted_total }}</span>
                </div>
                @if($order->payment_method === 'Kasir' && $order->amount_paid)
                <div class="price-row mt-2" style="border-top: 1px dashed #e2e8f0; padding-top: 10px;">
                    <span class="price-label">Uang Tunai (Cash)</span>
                    <span class="price-value">Rp {{ number_format($order->amount_paid, 0, ',', '.') }}</span>
                </div>
                <div class="price-row">
                    <span class="price-label" style="color: #10b981; font-weight: 700;">Kembalian</span>
                    <span class="price-value" style="color: #10b981; font-weight: 700;">Rp {{ number_format($order->change_amount, 0, ',', '.') }}</span>
                </div>
                @endif
            </div>
        </div>

        {{-- Footer --}}
        <div class="receipt-footer">
            <p class="footer-thankyou">Terima kasih telah berbelanja! 🎉</p>
            <p class="footer-sub">Jika ada pertanyaan, hubungi kami via WhatsApp<br>di <strong>088289188861</strong></p>
            <p class="footer-legal">Invoice ini sah dan diproses secara otomatis oleh sistem.<br>Tidak memerlukan tanda tangan basah.</p>
        </div>
    </div>

    {{-- Zigzag bottom edge --}}
    <div class="zigzag-edge"></div>

</body>
</html>
