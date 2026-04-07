@extends('layouts.app')
@section('title', 'Kontak')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="text-center mb-5">
                <h1 class="h3 fw-bold">Hubungi Kami</h1>
                <p class="text-muted">Ada pertanyaan atau saran? Kami siap membantu!</p>
            </div>

            <div class="card border-0 shadow-sm rounded-4 p-4">
                @if(session('success'))
                    <div class="alert alert-success rounded-3">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    </div>
                @endif

                <form id="waForm" onsubmit="sendToWA(event)">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold small">Nama</label>
                            <input type="text" id="waName" class="form-control rounded-3"
                                   value="{{ auth()->check() ? auth()->user()->name : '' }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold small">Email</label>
                            <input type="email" id="waEmail" class="form-control rounded-3"
                                   value="{{ auth()->check() ? auth()->user()->email : '' }}" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold small">Pesan</label>
                        <textarea id="waMessage" class="form-control rounded-3" rows="5"
                                  placeholder="Tulis pesan Anda di sini..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100 py-2 fw-semibold" style="border-radius: 10px;">
                        <i class="bi bi-whatsapp me-2"></i>Kirim via WhatsApp
                    </button>
                </form>
            </div>

            <div class="row g-3 mt-4">
                <div class="col-md-6 text-center">
                    <div class="p-3 bg-white rounded-3 shadow-sm border-0 h-100">
                        <i class="bi bi-envelope-fill text-primary fs-4 mb-2 d-block"></i>
                        <small class="fw-semibold d-block">Email</small>
                        <small class="text-muted">tokobuku@example.com</small>
                    </div>
                </div>
                <div class="col-md-6 text-center">
                    <div class="p-3 bg-white rounded-3 shadow-sm border-0 h-100">
                        <i class="bi bi-clock-fill text-primary fs-4 mb-2 d-block"></i>
                        <small class="fw-semibold d-block">Jam Operasional</small>
                        <small class="text-muted">Senin–Sabtu, 09:00–17:00</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function sendToWA(e) {
    e.preventDefault();
    const name = document.getElementById('waName').value;
    const email = document.getElementById('waEmail').value;
    const msg = document.getElementById('waMessage').value;
    
    const text = `Halo Admin Toko Buku Yusuf Firdaus!\n\n*Nama:* ${name}\n*Email:* ${email}\n\n*Pesan:*\n${msg}`;
    const url = `https://wa.me/6288289188861?text=${encodeURIComponent(text)}`;
    window.open(url, '_blank');
}
</script>
@endpush
@endsection
