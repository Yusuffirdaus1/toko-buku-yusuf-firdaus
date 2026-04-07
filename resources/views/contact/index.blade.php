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

                <form action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $e) <div>{{ $e }}</div> @endforeach
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold small">Nama</label>
                            <input type="text" name="name" class="form-control rounded-3"
                                   value="{{ old('name', auth()->user()->name ?? '') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold small">Email</label>
                            <input type="email" name="email" class="form-control rounded-3"
                                   value="{{ old('email', auth()->user()->email ?? '') }}" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold small">Pesan</label>
                        <textarea name="message" class="form-control rounded-3" rows="5"
                                  placeholder="Tulis pesan Anda di sini..." required>{{ old('message') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary-custom w-100 py-2 fw-semibold">
                        <i class="bi bi-send me-2"></i>Kirim Pesan
                    </button>
                </form>
            </div>

            <div class="row g-3 mt-4">
                <div class="col-md-4 text-center">
                    <div class="p-3 bg-white rounded-3 shadow-sm h-100 position-relative">
                        <i class="bi bi-telephone-fill text-primary fs-4 mb-2 d-block"></i>
                        <small class="fw-semibold d-block">Telepon / WhatsApp</small>
                        <small class="text-muted d-block mb-3">088289188861</small>
                        <a href="https://wa.me/6288289188861?text=Halo%20Admin%20Toko%20Buku%20Yusuf%20Firdaus" target="_blank" class="btn btn-sm btn-success rounded-pill mt-auto w-100" style="position: absolute; bottom: 15px; left: 50%; transform: translateX(-50%); width: 80% !important;">
                            <i class="bi bi-whatsapp me-1"></i>Chat WA
                        </a>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="p-3 bg-white rounded-3 shadow-sm">
                        <i class="bi bi-envelope-fill text-primary fs-4 mb-2 d-block"></i>
                        <small class="fw-semibold d-block">Email</small>
                        <small class="text-muted">tokobuku@example.com</small>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="p-3 bg-white rounded-3 shadow-sm">
                        <i class="bi bi-clock-fill text-primary fs-4 mb-2 d-block"></i>
                        <small class="fw-semibold d-block">Jam Operasional</small>
                        <small class="text-muted">Senin–Sabtu, 09:00–17:00</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
