@extends('layouts.admin')
@section('title','Detail Pesanan #' . $order->id)
@section('page-title','Detail Pesanan')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <h4>Pesanan #{{ $order->id }} — {{ $order->user->name }}</h4>
    <div>
        <a href="{{ route('admin.orders.invoice', $order) }}" target="_blank" class="btn btn-outline-primary rounded-3 me-2"><i class="bi bi-printer me-1"></i>Cetak Invoice</a>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary rounded-3"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="form-card mb-4">
            <h6 class="fw-bold mb-3">Item Pesanan</h6>
            @foreach($order->items as $item)
                <div class="d-flex gap-3 mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                    <img src="{{ $item->book->cover_url }}" width="50" height="65" style="object-fit:cover;border-radius:8px;">
                    <div class="flex-grow-1">
                        <p class="fw-semibold mb-0 small">{{ $item->book->title }}</p>
                        <small class="text-muted">{{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}</small>
                    </div>
                    <span class="fw-bold small">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                </div>
            @endforeach
            <div class="d-flex justify-content-between fw-bold border-top pt-3">
                <span>Total</span><span class="text-primary">{{ $order->formatted_total }}</span>
            </div>
        </div>

        {{-- Update Status --}}
        <div class="form-card">
            <h6 class="fw-bold mb-3">Update Status Pesanan</h6>
            <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                @csrf @method('PATCH')
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            @foreach(['pending','confirmed','shipped','completed','cancelled'] as $s)
                                <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kurir</label>
                        <input type="text" name="shipping_courier" class="form-control" value="{{ $order->shipping_courier }}"
                               placeholder="JNE, J&T, dll">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">No. Resi</label>
                        <input type="text" name="tracking_number" class="form-control" value="{{ $order->tracking_number }}"
                               placeholder="Nomor resi paket">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3 px-4">Update Status</button>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="form-card mb-4">
            <h6 class="fw-bold mb-3">Info Pelanggan</h6>
            <p class="mb-1 small"><strong>{{ $order->user->name }}</strong></p>
            <p class="text-muted small mb-1">{{ $order->user->email }}</p>
            <hr>
            <p class="mb-1 small"><i class="bi bi-geo-alt me-1"></i>{{ $order->address }}</p>
            <p class="mb-1 small"><i class="bi bi-telephone me-1"></i>{{ $order->phone }}</p>
            <p class="mb-0 small"><i class="bi bi-credit-card me-1"></i>{{ strtoupper($order->payment_method) }}</p>
        </div>


    </div>
</div>
@endsection
