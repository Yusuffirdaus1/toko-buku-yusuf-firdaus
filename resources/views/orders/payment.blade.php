@extends('layouts.app')
@section('title', 'Upload Bukti Pembayaran')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold mb-1"><i class="bi bi-upload me-2"></i>Upload Bukti Pembayaran</h5>
                <p class="text-muted small mb-4">Pesanan #{{ $order->id }} — Total: {{ $order->formatted_total }}</p>

                <div class="alert alert-info rounded-3 small">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Rekening Pembayaran:</strong><br>
                    BCA: <strong>1234567890</strong> a.n. Toko Buku Yusuf Firdaus<br>
                    BRI: <strong>0987654321</strong> a.n. Toko Buku Yusuf Firdaus
                </div>

                <form action="{{ route('orders.payment.upload', $order) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if($errors->any())
                        <div class="alert alert-danger"><i class="bi bi-exclamation-triangle me-2"></i>{{ $errors->first() }}</div>
                    @endif

                    <div class="mb-4">
                        <label class="form-label fw-semibold small">File Bukti Pembayaran</label>
                        <input type="file" name="proof" class="form-control rounded-3"
                               accept="image/*" required
                               onchange="previewImage(this)">
                        <div class="form-text">Format: JPG, PNG, WEBP. Maksimal 2MB.</div>
                        <img id="preview" src="#" class="img-fluid rounded-3 mt-3 d-none" style="max-height: 250px;">
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-secondary rounded-3">Batal</a>
                        <button type="submit" class="btn btn-primary-custom flex-grow-1">
                            <i class="bi bi-upload me-2"></i>Kirim Bukti Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('preview');
    if (input.files?.[0]) {
        preview.src = URL.createObjectURL(input.files[0]);
        preview.classList.remove('d-none');
    }
}
</script>
@endpush
@endsection
