@extends('layouts.app')
@section('title', 'Detail Pesanan #' . $order->id)

@section('content')
<div class="container py-5">
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-secondary rounded-3">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h1 class="h4 fw-bold mb-0">Detail Pesanan #{{ $order->id }}</h1>
        {!! $order->status_badge !!}
    </div>

    {{-- Progress Tracker --}}
    @if($order->status !== 'cancelled')
    <div class="card border-0 rounded-4 p-4 mb-4 shadow-sm" style="background-color: #f0f7ff;">
        <h6 class="text-primary fw-bold mb-4"><i class="bi bi-clock-history me-2"></i>Progress Transaksi</h6>
        
        <div class="position-relative d-flex justify-content-between align-items-center mt-2 px-2">
            {{-- Connecting Lines --}}
            <div class="position-absolute" style="top: 20px; left: 10%; right: 10%; height: 3px; background-color: #cbd5e1; z-index: 1;"></div>
            
            @php
                $statuses = ['pending', 'confirmed', 'shipped', 'completed'];
                $currentIndex = array_search($order->status, $statuses);
                if ($currentIndex === false) $currentIndex = 0; // fallback
            @endphp

            {{-- Step 1: Transaksi Dibuat --}}
            @php $isStep1Done = $currentIndex >= 0; @endphp
            <div class="position-relative text-center" style="z-index: 2; width: 25%;">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 shadow-sm" 
                     style="width: 44px; height: 44px; background-color: {{ $isStep1Done ? '#10b981' : '#ffffff' }}; border: 3px solid {{ $isStep1Done ? '#059669' : '#cbd5e1' }};">
                    <i class="bi bi-cart-check fs-5" style="color: {{ $isStep1Done ? '#fff' : '#cbd5e1' }};"></i>
                </div>
                <h6 class="mb-1 fw-bold" style="color: {{ $isStep1Done ? '#10b981' : '#64748b' }}; font-size: 0.9rem;">Transaksi Dibuat</h6>
                <small class="d-none d-md-block" style="color: {{ $isStep1Done ? '#64748b' : '#94a3b8' }}; font-size: 0.75rem;">Pesanan Anda berhasil dibuat.</small>
            </div>

            {{-- Line 1-2 progress --}}
            @if($currentIndex >= 1)
            <div class="position-absolute" style="top: 20px; left: 12.5%; width: 25%; height: 3px; background-color: #10b981; z-index: 1;"></div>
            @endif

            {{-- Step 2: Dikonfirmasi/Diproses --}}
            @php 
                $isStep2Done = $currentIndex >= 1; 
                $isStep2Active = $currentIndex === 1;
            @endphp
            <div class="position-relative text-center" style="z-index: 2; width: 25%;">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 shadow-sm" 
                     style="width: 44px; height: 44px; background-color: {{ $isStep2Done ? ($isStep2Active ? '#f97316' : '#10b981') : '#ffffff' }}; border: 3px solid {{ $isStep2Done ? ($isStep2Active ? '#ea580c' : '#059669') : '#cbd5e1' }};">
                    <i class="bi bi-box-seam fs-5" style="color: {{ $isStep2Done ? '#fff' : '#cbd5e1' }};"></i>
                </div>
                <h6 class="mb-1 fw-bold" style="color: {{ $isStep2Done ? ($isStep2Active ? '#ea580c' : '#10b981') : '#64748b' }}; font-size: 0.9rem;">Sedang Diproses</h6>
                <small class="d-none d-md-block" style="color: {{ $isStep2Done ? '#64748b' : '#94a3b8' }}; font-size: 0.75rem;">Barang disiapkan & dikemas.</small>
            </div>

            {{-- Line 2-3 progress --}}
            @if($currentIndex >= 2)
            <div class="position-absolute" style="top: 20px; left: 37.5%; width: 25%; height: 3px; background-color: #10b981; z-index: 1;"></div>
            @endif

            {{-- Step 3: Sedang Dikirim --}}
            @php 
                $isStep3Done = $currentIndex >= 2; 
                $isStep3Active = $currentIndex === 2;
            @endphp
            <div class="position-relative text-center" style="z-index: 2; width: 25%;">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 shadow-sm" 
                     style="width: 44px; height: 44px; background-color: {{ $isStep3Done ? ($isStep3Active ? '#f97316' : '#10b981') : '#ffffff' }}; border: 3px solid {{ $isStep3Done ? ($isStep3Active ? '#ea580c' : '#059669') : '#cbd5e1' }};">
                    <i class="bi bi-truck fs-5" style="color: {{ $isStep3Done ? '#fff' : '#cbd5e1' }};"></i>
                </div>
                <h6 class="mb-1 fw-bold" style="color: {{ $isStep3Done ? ($isStep3Active ? '#ea580c' : '#10b981') : '#64748b' }}; font-size: 0.9rem;">Sedang Dikirim</h6>
                <small class="d-none d-md-block" style="color: {{ $isStep3Done ? '#64748b' : '#94a3b8' }}; font-size: 0.75rem;">Paket dalam perjalanan.</small>
            </div>

            {{-- Line 3-4 progress --}}
            @if($currentIndex >= 3)
            <div class="position-absolute" style="top: 20px; left: 62.5%; width: 25%; height: 3px; background-color: #10b981; z-index: 1;"></div>
            @endif

            {{-- Step 4: Selesai --}}
            @php $isStep4Done = $currentIndex >= 3; @endphp
            <div class="position-relative text-center" style="z-index: 2; width: 25%;">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 shadow-sm" 
                     style="width: 44px; height: 44px; background-color: {{ $isStep4Done ? '#10b981' : '#ffffff' }}; border: 3px solid {{ $isStep4Done ? '#059669' : '#cbd5e1' }};">
                    <i class="bi bi-check2-all fs-5" style="color: {{ $isStep4Done ? '#fff' : '#cbd5e1' }};"></i>
                </div>
                <h6 class="mb-1 fw-bold" style="color: {{ $isStep4Done ? '#10b981' : '#64748b' }}; font-size: 0.9rem;">Transaksi Selesai</h6>
                <small class="d-none d-md-block" style="color: {{ $isStep4Done ? '#64748b' : '#94a3b8' }}; font-size: 0.75rem;">Paket berhasil diterima.</small>
            </div>
        </div>
    </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <h6 class="fw-bold mb-3">Item Pesanan</h6>
                @foreach($order->items as $item)
                    <div class="d-flex gap-3 mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <img src="{{ $item->book->cover_url }}" width="55" height="70"
                             style="object-fit: cover; border-radius: 8px;" alt="">
                        <div class="flex-grow-1">
                            <p class="fw-semibold mb-0">{{ $item->book->title }}</p>
                            <small class="text-muted">{{ $item->book->author }}</small>
                            <p class="mt-1 mb-0 small">{{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>
                        <span class="fw-bold text-primary">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                @endforeach
                <div class="d-flex justify-content-between fw-bold pt-2 border-top mt-2">
                    <span>Total</span>
                    <span class="text-primary">{{ $order->formatted_total }}</span>
                </div>
            </div>

            @if($order->status === 'pending' || $order->status === 'confirmed')
                <div class="alert alert-info border-0 rounded-4 shadow-sm mb-4" style="background-color: #e0f2fe; color: #0284c7;">
                    <h6 class="fw-bold"><i class="bi bi-info-circle-fill me-2"></i>Instruksi COD (Bayar di Tempat)</h6>
                    <p class="mb-0" style="font-size: 0.9rem;">Admin kami sedang menyiapkan buku pesanan Anda. Karena Anda menggunakan metode COD, pastikan Anda menyiapkan uang tunai sebesar <strong>{{ $order->formatted_total }}</strong> untuk diberikan kepada kurir saat paket tiba di alamat Anda.</p>
                </div>
            @endif

            @if($order->status === 'shipped')
                <div class="card border-0 shadow-sm rounded-4 mb-4" style="background-color: #ecfdf5; border: 1px solid #10b981 !important;">
                    <div class="card-body p-4 text-center">
                        <div class="d-inline-flex justify-content-center align-items-center mb-3" style="width: 60px; height: 60px; background: #d1fae5; border-radius: 50%;">
                            <i class="bi bi-box2-heart text-success" style="font-size: 2rem;"></i>
                        </div>
                        <h6 class="fw-bold text-success mb-2">Paket Sedang Dalam Perjalanan!</h6>
                        <p class="text-muted small mb-4" style="max-width: 400px; margin: 0 auto;">Kurir sedang menuju alamat Anda. Harap siapkan uang tunai Anda. Jika paket sudah tiba di tangan Anda dan pembayaran telah selesai, silakan tekan tombol konfirmasi di bawah ini.</p>
                        
                        <form action="{{ route('orders.complete', $order) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success fw-bold px-4 py-2 rounded-pill shadow-sm" onclick="return confirm('Apakah Anda yakin paket sudah diterima dengan baik dan pembayaran telah diserahkan ke kurir?')">
                                <i class="bi bi-check-circle-fill me-2"></i>Pesanan Sudah Saya Terima
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            @if($order->status === 'completed')
                <div class="alert alert-success border-0 rounded-4 shadow-sm mb-4 d-flex align-items-center gap-3">
                    <i class="bi bi-patch-check-fill fs-1 text-success"></i>
                    <div>
                        <h6 class="fw-bold mb-1">Transaksi Selesai</h6>
                        <p class="mb-0" style="font-size: 0.9rem;">Terima kasih telah berbelanja di Toko Buku Yusuf Firdaus! Kami tunggu pesanan Anda selanjutnya.</p>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h6 class="fw-bold mb-3">Info Pengiriman</h6>
                <table class="table table-sm table-borderless">
                    <tr><td class="text-muted small">Alamat</td><td class="small fw-semibold">{{ $order->address }}</td></tr>
                    <tr><td class="text-muted small">Telepon</td><td class="small fw-semibold">{{ $order->phone }}</td></tr>
                    <tr><td class="text-muted small">Pembayaran</td><td class="small fw-semibold">{{ strtoupper($order->payment_method) }}</td></tr>
                    @if($order->shipping_courier)
                        <tr><td class="text-muted small">Kurir</td><td class="small fw-semibold">{{ $order->shipping_courier }}</td></tr>
                    @endif
                    @if($order->tracking_number)
                        <tr><td class="text-muted small">No. Resi</td><td class="small fw-semibold">{{ $order->tracking_number }}</td></tr>
                    @endif
                    @if($order->shipped_at)
                        <tr><td class="text-muted small">Dikirim</td><td class="small fw-semibold">{{ $order->shipped_at->format('d M Y') }}</td></tr>
                    @endif
                    <tr><td class="text-muted small">Tanggal Order</td><td class="small fw-semibold">{{ $order->created_at->format('d M Y H:i') }}</td></tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
