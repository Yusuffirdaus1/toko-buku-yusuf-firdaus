@extends('layouts.app')
@section('title', 'Daftar - Toko Buku')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-lg rounded-4 p-4">
                <div class="text-center mb-4">
                    <div class="mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg,#f97316,#fdba74); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="bi bi-person-plus text-white" style="font-size: 1.5rem;"></i>
                    </div>
                    <h4 class="fw-bold">Buat Akun Baru</h4>
                    <p class="text-muted small">Bergabung dan mulai belanja buku!</p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control rounded-3"
                               value="{{ old('name') }}" placeholder="Nama Anda" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Email</label>
                        <input type="email" name="email" class="form-control rounded-3"
                               value="{{ old('email') }}" placeholder="email@contoh.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Password</label>
                        <input type="password" name="password" class="form-control rounded-3"
                               placeholder="Minimal 8 karakter" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold small">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control rounded-3"
                               placeholder="Ulangi password" required>
                    </div>
                    <button type="submit" class="btn w-100 py-2 fw-semibold rounded-3 text-white"
                            style="background: linear-gradient(135deg, #f97316, #ea580c);">
                        <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
                    </button>
                </form>

                <p class="text-center mt-4 mb-0 small">
                    Sudah punya akun? <a href="{{ route('login') }}" class="fw-semibold text-primary">Masuk di sini</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
