@extends('layouts.admin')
@section('title','Detail Pembayaran')
@section('page-title','Detail Pembayaran')

@section('content')
<div class="page-header">
    <h4>Bukti Pembayaran #{{ $payment->id }}</h4>
    <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary rounded-3"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="form-card">
            <h6 class="fw-bold mb-3">File Bukti Pembayaran</h6>
            <img src="{{ $payment->file_url }}" class="img-fluid rounded-3 mb-3" style="max-height: 400px; object-fit: contain; width: 100%;">
            <p>Status: <span class="badge {{ $payment->status === 'confirmed' ? 'bg-success' : ($payment->status === 'rejected' ? 'bg-danger' : 'bg-warning text-dark') }} fs-6">
                {{ ucfirst($payment->status) }}
            </span></p>

            @if($payment->status === 'pending')
                <div class="d-flex gap-2">
                    <form action="{{ route('admin.payments.confirm', $payment) }}" method="POST" class="flex-grow-1">
                        @csrf @method('PATCH')
                        <button class="btn btn-success w-100 fw-semibold rounded-3">
                            <i class="bi bi-check-circle me-2"></i>Konfirmasi Pembayaran
                        </button>
                    </form>
                    <form action="{{ route('admin.payments.reject', $payment) }}" method="POST" class="flex-grow-1">
                        @csrf @method('PATCH')
                        <button class="btn btn-danger w-100 fw-semibold rounded-3" onclick="return confirm('Tolak pembayaran ini?')">
                            <i class="bi bi-x-circle me-2"></i>Tolak
                        </button>
                    </form>
                </div>
            @elseif($payment->confirmed_by)
                <small class="text-muted">Dikonfirmasi oleh: {{ $payment->confirmedBy->name }}</small>
            @endif
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-card">
            <h6 class="fw-bold mb-3">Info Pesanan #{{ $payment->order_id }}</h6>
            <p class="small"><strong>Pelanggan:</strong> {{ $payment->user->name }}</p>
            <p class="small"><strong>Email:</strong> {{ $payment->user->email }}</p>
            <p class="small"><strong>Total:</strong> {{ $payment->order->formatted_total }}</p>
            <p class="small"><strong>Status Pesanan:</strong> {!! $payment->order->status_badge !!}</p>
            <hr>
            <h6 class="fw-bold">Item Pesanan</h6>
            @foreach($payment->order->items as $item)
                <div class="d-flex gap-2 mb-2">
                    <img src="{{ $item->book->cover_url }}" width="40" height="52" style="object-fit:cover;border-radius:6px;">
                    <div>
                        <p class="mb-0 small fw-semibold">{{ $item->book->title }}</p>
                        <small class="text-muted">{{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}</small>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
