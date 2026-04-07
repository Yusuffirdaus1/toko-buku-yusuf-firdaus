@extends('layouts.app')
@section('title', 'Checkout')

@section('content')
<div class="container py-5">
    <h1 class="h4 fw-bold mb-4"><i class="bi bi-credit-card me-2"></i>Checkout</h1>
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h6 class="fw-bold mb-3">Informasi Pengiriman</h6>
                <form action="{{ route('orders.store') }}" method="POST" id="checkoutForm">
                    @csrf
                    @foreach($cartItems as $item)
                        <input type="hidden" name="cart_ids[]" value="{{ $item->id }}">
                    @endforeach
                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $e) <div>{{ $e }}</div> @endforeach
                        </div>
                    @endif
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea name="address" class="form-control rounded-3" rows="3"
                                  placeholder="Jl. Contoh No. 1, Kota, Provinsi, Kode Pos" required>{{ old('address') }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold small">Nomor Telepon <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control rounded-3"
                                   value="{{ old('phone', auth()->user()->phone ?? '') }}"
                                   placeholder="08xxxxxxxxxx" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold small">Kurir Pengiriman</label>
                            <select name="shipping_courier" class="form-select rounded-3">
                                <option value="">Pilih Kurir</option>
                                <option value="JNE">JNE</option>
                                <option value="J&T">J&T Express</option>
                                <option value="SiCepat">SiCepat</option>
                                <option value="Pos Indonesia">Pos Indonesia</option>
                                <option value="Gosend">Gosend</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold small">Metode Pembayaran</label>
                        <div class="alert alert-info py-3 mb-0 rounded-3">
                            <h6 class="fw-bold mb-1"><i class="bi bi-wallet2 me-2"></i>Cash on Delivery (COD)</h6>
                            <small>Pembayaran dilakukan secara langsung kepada kurir saat pesanan tiba di alamat Anda.</small>
                            <input type="hidden" name="payment_method" value="COD">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary-custom w-100 py-2 fw-semibold"
                            onclick="return confirm('Konfirmasi pesanan dengan metode pembayaran di tempat (COD)?')">
                        <i class="bi bi-bag-check me-2"></i>Buat Pesanan
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h6 class="fw-bold mb-3">Ringkasan Pesanan</h6>
                @foreach($cartItems as $item)
                    <div class="d-flex gap-3 mb-3 pb-3 border-bottom">
                        <img src="{{ $item->book->cover_url }}" width="45" height="58"
                             style="object-fit: cover; border-radius: 6px;" alt="">
                        <div class="flex-grow-1">
                            <p class="fw-semibold mb-0" style="font-size: 0.82rem;">{{ $item->book->title }}</p>
                            <small class="text-muted">{{ $item->quantity }} × {{ $item->book->formatted_price }}</small>
                        </div>
                        <span class="fw-bold text-primary small">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </span>
                    </div>
                @endforeach
                <div class="d-flex justify-content-between fw-bold mt-2">
                    <span>Total Pembayaran</span>
                    <span class="text-primary" style="font-size: 1.1rem;">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
