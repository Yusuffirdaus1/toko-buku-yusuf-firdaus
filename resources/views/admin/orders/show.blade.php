@extends('layouts.admin')
@section('title', 'Detail Pesanan #' . $order->id)
@section('page-title', 'Detail Pesanan')

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <h4>Pesanan #{{ $order->id }} — {{ $order->user->name }}</h4>
        <div>
            <a href="{{ route('admin.orders.invoice', $order) }}" target="_blank"
                class="btn btn-outline-primary rounded-3 me-2"><i class="bi bi-printer me-1"></i>Cetak Invoice</a>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary rounded-3"><i
                    class="bi bi-arrow-left me-1"></i>Kembali</a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="form-card mb-4">
                <h6 class="fw-bold mb-3">Item Pesanan</h6>
                @foreach($order->items as $item)
                    <div class="d-flex gap-3 mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <img src="{{ $item->book->cover_url }}" width="50" height="65"
                            style="object-fit:cover;border-radius:8px;">
                        <div class="flex-grow-1">
                            <p class="fw-semibold mb-0 small">{{ $item->book->title }}</p>
                            <small class="text-muted">{{ $item->quantity }} × Rp
                                {{ number_format($item->price, 0, ',', '.') }}</small>
                        </div>
                        <span class="fw-bold small">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                @endforeach
                <div class="border-top pt-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">Total Tagihan</span>
                        <span class="fw-bold">{{ $order->formatted_total }}</span>
                    </div>
                    @if($order->amount_paid)
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Uang Tunai (Cash)</span>
                            <span class="fw-bold">Rp {{ number_format($order->amount_paid, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between text-success">
                            <span class="small fw-bold">Kembalian</span>
                            <span class="fw-bold">Rp {{ number_format($order->change_amount, 0, ',', '.') }}</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Bayar di Kasir Form --}}
            @if($order->payment_method === 'Kasir' && $order->status === 'pending')
                <div class="form-card mb-4 border border-primary">
                    <h6 class="fw-bold mb-3 text-primary"><i class="bi bi-cash-coin me-2"></i>Pembayaran Kasir</h6>
                    <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="completed">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Uang Tunai Pelanggan</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="amount_paid" id="kasir_paid" class="form-control form-control-lg" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-success w-100 py-2 fw-bold" onclick="return confirm('Proses pembayaran tunai?')">
                                    TERIMA PEMBAYARAN
                                </button>
                            </div>
                        </div>
                        <div class="mt-2 text-muted small">
                            Total Tagihan: <strong>{{ $order->formatted_total }}</strong>
                        </div>
                    </form>
                </div>
            @endif

            {{-- Update Status --}}
            <div class="form-card">
                <h6 class="fw-bold mb-3">Update Status Pesanan</h6>
                <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                    @csrf @method('PATCH')
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                @foreach(['pending', 'confirmed', 'shipped', 'completed', 'cancelled'] as $s)
                                    <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @if($order->payment_method === 'Kasir')
                            <div class="col-md-4">
                                <label class="form-label">Uang Tunai (Cash)</label>
                                <div class="input-group">
                                    <span class="input-group-text small">Rp</span>
                                    <input type="number" name="amount_paid" class="form-control"
                                        value="{{ $order->amount_paid }}" placeholder="Contoh: 100000">
                                </div>
                            </div>
                        @endif
                        @if($order->payment_method === 'QRIS')
                            <div class="col-md-4">
                                <label class="form-label">Kurir</label>
                                <input type="text" name="shipping_courier" class="form-control"
                                    value="{{ $order->shipping_courier }}" placeholder="JNE, J&T, dll">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">No. Resi</label>
                                <input type="text" name="tracking_number" class="form-control"
                                    value="{{ $order->tracking_number }}" placeholder="Nomor resi paket">
                            </div>
                        @endif
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