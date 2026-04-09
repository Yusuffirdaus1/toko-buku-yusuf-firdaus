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
                    <div class="mb-4">
                        <label class="form-label fw-semibold small">Metode Pembayaran <span class="text-danger">*</span></label>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="payment-option-card px-3 py-3 border rounded-4 d-block cursor-pointer position-relative h-100" for="pay_qris">
                                    <input type="radio" name="payment_method" value="QRIS" id="pay_qris" class="form-check-input position-absolute top-10 end-10" checked>
                                    <div class="text-center pt-2">
                                        <i class="bi bi-qr-code text-primary fs-3 d-block mb-1"></i>
                                        <span class="d-block fw-bold small">QRIS (Online)</span>
                                        <small class="text-muted" style="font-size: 0.65rem;">Scan & Upload Bukti</small>
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="payment-option-card px-3 py-3 border rounded-4 d-block cursor-pointer position-relative h-100" for="pay_kasir">
                                    <input type="radio" name="payment_method" value="Kasir" id="pay_kasir" class="form-check-input position-absolute top-10 end-10">
                                    <div class="text-center pt-2">
                                        <i class="bi bi-shop text-success fs-3 d-block mb-1"></i>
                                        <span class="d-block fw-bold small">Bayar di Kasir</span>
                                        <small class="text-muted" style="font-size: 0.65rem;">Datang ke Toko</small>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div id="shipping_info_section">
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Alamat Lengkap <span class="text-danger">*</span></label>
                            <textarea name="address" class="form-control rounded-3" rows="3"
                                      placeholder="Jl. Contoh No. 1, Kota, Provinsi, Kode Pos">{{ old('address') }}</textarea>
                        </div>
                        <div class="col-md-12 mb-3">
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

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Nomor Telepon <span class="text-danger">*</span></label>
                        <input type="text" name="phone" class="form-control rounded-3"
                               value="{{ old('phone', auth()->user()->phone ?? '') }}"
                               placeholder="08xxxxxxxxxx" required>
                    </div>

                    <button type="submit" class="btn btn-primary-custom w-100 py-3 fw-bold shadow-sm" id="submitBtn">
                        <i class="bi bi-bag-check me-2"></i>Buat Pesanan
                    </button>
                    @push('styles')
                    <style>
                        .payment-option-card { border: 2px solid #f1f5f9; cursor: pointer; transition: 0.2s; }
                        input[name="payment_method"]:checked + div { opacity: 1; }
                        label:has(input[name="payment_method"]:checked) { border-color: #4f46e5 !important; background: #f5f3ff; }
                        .top-10 { top: 10px; } .end-10 { right: 10px; }
                    </style>
                    @endpush
                    @push('scripts')
                    <script>
                        document.querySelectorAll('input[name="payment_method"]').forEach(r => {
                            r.addEventListener('change', function() {
                                const s = document.getElementById('shipping_info_section');
                                if(this.value === 'Kasir') {
                                    s.style.display = 'none';
                                    document.getElementById('submitBtn').innerHTML = '<i class="bi bi-shop me-2"></i>Pesan & Bayar di Toko';
                                } else {
                                    s.style.display = 'block';
                                    document.getElementById('submitBtn').innerHTML = '<i class="bi bi-bag-check me-2"></i>Buat Pesanan & Bayar QRIS';
                                }
                            });
                        });
                    </script>
                    @endpush
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
                        <span class="text-primary" style="font-size: 1.1rem;">Rp
                            {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection