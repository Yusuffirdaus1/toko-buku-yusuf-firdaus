@extends('layouts.app')
@section('title', 'Login - Toko Buku')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-lg rounded-4 p-4">
                <div class="text-center mb-4">
                    <div class="mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg,#4f46e5,#818cf8); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="bi bi-book-half text-white" style="font-size: 1.5rem;"></i>
                    </div>
                    <h4 class="fw-bold">Masuk ke Akun</h4>
                    <p class="text-muted small">Selamat datang kembali!</p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i>{{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Email</label>
                        <input type="email" name="email" class="form-control rounded-3"
                               value="{{ old('email') }}" placeholder="email@contoh.com" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Password</label>
                        <input type="password" name="password" class="form-control rounded-3"
                               placeholder="Minimal 8 karakter" required>
                    </div>
                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" name="remember" id="remember">
                        <label class="form-check-label small" for="remember">Ingat saya</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold rounded-3">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                    </button>
                </form>

                <p class="text-center mt-4 mb-0 small">
                    Belum punya akun? <a href="{{ route('register') }}" class="fw-semibold text-primary">Daftar sekarang</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
