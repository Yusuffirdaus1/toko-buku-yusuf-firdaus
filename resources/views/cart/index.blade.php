@extends('layouts.app')
@section('title', 'Keranjang Belanja')

@section('content')
<div class="container py-5">
    <h1 class="h4 fw-bold mb-4"><i class="bi bi-cart3 me-2"></i>Keranjang Belanja</h1>

    @if($cartItems->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-cart-x" style="font-size: 4rem; color: #cbd5e1;"></i>
            <h5 class="mt-3 text-muted">Keranjang Anda masih kosong</h5>
            <a href="{{ route('books.index') }}" class="btn btn-primary-custom mt-3 px-4">
                <i class="bi bi-book me-2"></i>Mulai Belanja
            </a>
        </div>
    @else
        <form action="{{ route('checkout') }}" method="GET" id="checkoutForm">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 50px;" class="text-center">
                                            <input class="form-check-input" type="checkbox" id="checkAll" checked>
                                        </th>
                                        <th>Buku</th>
                                        <th class="text-center">Harga</th>
                                        <th class="text-center" style="width: 140px;">Jumlah</th>
                                        <th class="text-center">Subtotal</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartItems as $item)
                                        <tr>
                                            <td class="text-center">
                                                <input class="form-check-input item-check" type="checkbox" name="cart_ids[]" value="{{ $item->id }}" data-price="{{ $item->subtotal }}" checked>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    <img src="{{ $item->book->cover_url }}" width="55" height="70"
                                                         style="object-fit: cover; border-radius: 8px;" alt="">
                                                    <div>
                                                        <p class="fw-semibold mb-0" style="font-size: 0.875rem;">{{ $item->book->title }}</p>
                                                        <small class="text-muted">{{ $item->book->author }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center" style="font-size: 0.875rem;">{{ $item->book->formatted_price }}</td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-center">
                                                    {{-- Let's not use forms inside a form. Use JS or a separate action/button for update.
                                                    Alternatively, standard ecommerce cart updates via JS or a side-button. --}}
                                                    <a href="{{ route('cart.update.get', ['cart' => $item, 'action' => 'dec']) }}" class="btn btn-sm btn-light border py-0 px-2">-</a>
                                                    <input type="text" value="{{ $item->quantity }}" class="form-control form-control-sm text-center mx-1 bg-white border-0" style="width: 40px;" readonly>
                                                    <a href="{{ route('cart.update.get', ['cart' => $item, 'action' => 'inc']) }}" class="btn btn-sm btn-light border py-0 px-2">+</a>
                                                </div>
                                            </td>
                                            <td class="text-center fw-bold text-primary" style="font-size: 0.875rem;">
                                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                            </td>
                                            <td>
                                                <a href="{{ route('cart.destroy.get', $item) }}" class="btn btn-sm btn-outline-danger rounded-3"
                                                   onclick="return confirm('Hapus item ini?')">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top" style="top: 20px;">
                        <h6 class="fw-bold mb-3">Ringkasan Pesanan</h6>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Total Produk Dipilih</span>
                            <span class="fw-semibold" id="selectedCount">{{ $cartItems->count() }} item</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold">Total Pembayaran</span>
                            <span class="fw-bold text-primary" style="font-size: 1.1rem;" id="totalPrice">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <button type="submit" class="btn btn-primary-custom w-100 py-2 fw-semibold" id="checkoutBtn">
                            <i class="bi bi-credit-card me-2"></i>Lanjut Checkout
                        </button>
                        <a href="{{ route('books.index') }}" class="btn btn-outline-secondary btn-sm w-100 mt-2 rounded-3">
                            <i class="bi bi-arrow-left me-1"></i>Lanjut Belanja
                        </a>
                    </div>
                </div>
            </div>
        </form>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkAll = document.getElementById('checkAll');
    const itemChecks = document.querySelectorAll('.item-check');
    const selectedCountEl = document.getElementById('selectedCount');
    const totalPriceEl = document.getElementById('totalPrice');
    const checkoutBtn = document.getElementById('checkoutBtn');

    function calculateTotal() {
        let total = 0;
        let count = 0;
        let allChecked = true;

        itemChecks.forEach(check => {
            if (check.checked) {
                total += parseFloat(check.dataset.price);
                count++;
            } else {
                allChecked = false;
            }
        });

        checkAll.checked = allChecked && itemChecks.length > 0;
        selectedCountEl.textContent = count + ' item';
        totalPriceEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
        checkoutBtn.disabled = count === 0;
    }

    if(checkAll) {
        checkAll.addEventListener('change', function() {
            itemChecks.forEach(check => check.checked = this.checked);
            calculateTotal();
        });
    }

    itemChecks.forEach(check => {
        check.addEventListener('change', calculateTotal);
    });

    // Validasi form
    document.getElementById('checkoutForm')?.addEventListener('submit', function(e) {
        const checkedItems = document.querySelectorAll('.item-check:checked');
        if (checkedItems.length === 0) {
            e.preventDefault();
            alert('Silakan pilih minimal satu buku untuk dicheckout.');
        }
    });
});
</script>
@endpush
@endsection
