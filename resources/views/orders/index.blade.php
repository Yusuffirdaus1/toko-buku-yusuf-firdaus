@extends('layouts.app')
@section('title', 'Histori Pesanan')

@section('content')
<div class="container py-5" style="max-width: 800px;">
    <h1 class="h4 fw-bold mb-4"><i class="bi bi-receipt me-2"></i>Histori Pesanan Saya</h1>

    @if($orders->isEmpty())
        <div class="text-center py-5 bg-white shadow-sm rounded-4 border-0">
            <i class="bi bi-bag-x" style="font-size: 4rem; color: #cbd5e1;"></i>
            <h5 class="mt-3 text-muted">Belum ada pesanan</h5>
            <p class="small text-muted mb-4">Yuk, temukan buku-buku menarik di toko kami!</p>
            <a href="{{ route('books.index') }}" class="btn btn-primary-custom px-4 rounded-pill">Mulai Belanja</a>
        </div>
    @else
        <div class="d-flex flex-column gap-4">
            @foreach($orders as $order)
                <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
                    {{-- Card Header: Status & Date --}}
                    <div class="card-header bg-white border-bottom d-flex flex-wrap justify-content-between align-items-center py-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-bag-check-fill text-primary" style="font-size: 1.2rem;"></i>
                            <span class="fw-bold" style="font-size: 0.95rem;">Belanja</span>
                            <span class="text-muted small mx-1">&bull;</span>
                            <span class="text-muted small">{{ $order->created_at->format('d M Y') }}</span>
                            <span class="text-muted small mx-1">&bull;</span>
                            <span class="text-muted small">Pesanan #{{ $order->id }}</span>
                        </div>
                        <div class="mt-2 mt-md-0">
                            {!! $order->status_badge !!}
                        </div>
                    </div>

                    {{-- Card Body: Items --}}
                    <div class="card-body p-0">
                        @foreach($order->items as $item)
                        <div class="p-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                            <div class="d-flex gap-3 align-items-start">
                                {{-- Book Cover Image --}}
                                <div style="width: 70px; height: 100px; background-color: #f1f5f9; padding: 0.25rem; border-radius: 8px; flex-shrink: 0;">
                                    <img src="{{ $item->book->cover_url }}" alt="{{ $item->book->title }}" 
                                         class="w-100 h-100" style="object-fit: contain; aspect-ratio: 2/3; mix-blend-mode: multiply;">
                                </div>
                                
                                {{-- Book Title & Qty --}}
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-1 text-dark" style="font-size: 0.95rem;">{{ $item->book->title }}</h6>
                                    <p class="text-muted small mb-1">{{ $item->book->author }}</p>
                                    <p class="text-muted small mb-0">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                                
                                {{-- Item Price Total --}}
                                <div class="text-end ms-3">
                                    <p class="text-muted small mb-0 d-none d-md-block">Total Harga Item</p>
                                    <p class="fw-bold mb-0" style="color: #4f46e5; font-size: 1rem;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Card Footer: Total & Actions --}}
                    <div class="card-footer bg-white border-top d-flex flex-wrap justify-content-between align-items-center py-3">
                        <div class="d-flex flex-column mb-2 mb-md-0">
                            <span class="text-muted small">Total Belanja</span>
                            <span class="fw-bold fs-5 text-dark">{{ $order->formatted_total }}</span>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-primary-custom px-4 fw-semibold rounded-pill">
                                Lihat Detail Transaksi
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
