@extends('layouts.app')
@section('title', 'Beranda - Toko Buku Yusuf Firdaus')

@section('content')
{{-- Hero Carousel --}}
<div class="container mt-4">
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" style="border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
    <div class="carousel-indicators">
        @forelse($mainCarousels as $i => $banner)
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $i }}"
                class="{{ $i === 0 ? 'active' : '' }}"></button>
        @empty
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
        @endforelse
    </div>

    <div class="carousel-inner">
        @forelse($mainCarousels as $i => $banner)
            <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                <div style="position: relative; width: 100%; height: clamp(250px, 40vw, 450px);">
                    <div style="position: absolute; top:0; left:0; width:100%; height:100%; background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0) 60%); z-index: 1;"></div>
                    <img src="{{ $banner->image_url }}" class="d-block w-100 h-100" style="object-fit: cover; object-position: center;" alt="{{ $banner->title }}">
                </div>
                <div class="carousel-caption d-none d-md-block" style="z-index: 2; bottom: 30px; text-shadow: 0 2px 4px rgba(0,0,0,0.8);">
                    <h2 class="fw-bold text-white mb-2">{{ $banner->title }}</h2>
                    @if($banner->description)
                        <p>{{ $banner->description }}</p>
                    @endif
                    @if($banner->link)
                        <a href="{{ $banner->link }}" class="btn btn-warning fw-bold rounded-pill px-4">Lihat Promo</a>
                    @endif
                </div>
            </div>
        @empty
            <div class="carousel-item active">
                <div class="d-flex align-items-center justify-content-center text-white"
                     style="height: clamp(250px, 40vw, 450px); background: linear-gradient(135deg, #4f46e5, #06b6d4);">
                    <div class="text-center">
                        <i class="bi bi-book-half" style="font-size: 4rem;"></i>
                        <h2 class="fw-bold mt-3">Selamat Datang di Toko Buku</h2>
                        <p class="fs-5">Temukan buku favorit Anda dengan harga terbaik</p>
                        <a href="{{ route('books.index') }}" class="btn btn-warning fw-bold rounded-pill px-5 mt-2">Mulai Belanja</a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
    </div>
</div>

{{-- About Us Section --}}
<div class="container my-5">
    <div class="row align-items-center bg-white rounded-4 shadow-sm overflow-hidden border-0">
        <div class="col-md-6 p-0">
            <div style="background: linear-gradient(135deg, #4f46e5, #0ea5e9); height: 100%; min-height: 400px; display: flex; flex-direction: column; align-items: center; justify-content: center; position: relative;">
                <div style="position: absolute; width: 200px; height: 200px; background: rgba(255,255,255,0.1); border-radius: 50%; top: -50px; left: -50px;"></div>
                <div style="position: absolute; width: 300px; height: 300px; background: rgba(255,255,255,0.05); border-radius: 50%; bottom: -100px; right: -50px;"></div>
                <i class="bi bi-book-fill text-white mb-3" style="font-size: 6rem; z-index: 1;"></i>
                <h3 class="text-white fw-bold z-index-1" style="z-index: 1; letter-spacing: 1px;">Yusuf Firdaus</h3>
            </div>
        </div>
        <div class="col-md-6 p-5">
            <span class="text-primary fw-bold mb-2 d-block text-uppercase" style="letter-spacing: 1px; font-size: 0.85rem;"><i class="bi bi-info-circle-fill me-2"></i>Tentang Kami</span>
            <h2 class="fw-bold mb-4" style="color: #0f172a;">Toko Buku Yusuf Firdaus</h2>
            <p class="text-muted" style="line-height: 1.8; font-size: 1.05rem;">
                Selamat datang di <strong>Toko Buku Yusuf Firdaus</strong>, destinasi eksklusif Anda untuk menemukan narasi terbaik dan jendela menuju wawasan tanpa batas. Kami berdedikasi tinggi untuk memilihkan literatur berkualitas dari fiksi, non-fiksi, pendidikan, hingga pengembangan diri.
            </p>
            <p class="text-muted mb-4" style="line-height: 1.8; font-size: 1.05rem;">
                Lebih dari sekadar toko, kami adalah ruang perayaan inspirasi. Misi utama kami adalah mendekatkan setiap ide dan pemikiran brilian kepada Anda melalui pengalaman transaksi belanja buku yang modern, sederhana, namun tetap menjunjung tinggi kualitas layanan.
            </p>
            <div class="d-flex gap-4">
                <div>
                    <h4 class="fw-bold text-primary mb-0">1000+</h4>
                    <span class="text-muted fw-semibold small">Koleksi Terkurasi</span>
                </div>
                <div style="width: 1px; background: #e2e8f0;"></div>
                <div>
                    <h4 class="fw-bold text-primary mb-0">100%</h4>
                    <span class="text-muted fw-semibold small">Buku Original</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Fitur & Keunggulan Web --}}
<div class="container my-5 py-3">
    <div class="text-center mb-5">
        <span class="text-primary fw-bold mb-2 d-block text-uppercase" style="letter-spacing: 1px; font-size: 0.85rem;">Keunggulan Kami</span>
        <h2 class="fw-bold" style="color: #0f172a;">Kenapa Belanja Buku di Sini?</h2>
        <p class="text-muted mx-auto mt-3" style="max-width: 600px;">Kami menjamin kenyamanan penuh dengan fasilitas eksklusif agar pengalaman belanja buku Anda menjadi sangat menyenangkan dan aman.</p>
    </div>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4 text-center" style="transition: transform 0.3s; cursor: pointer;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="d-inline-flex justify-content-center align-items-center mb-4" style="width: 70px; height: 70px; background: #eef2ff; border-radius: 50%;">
                    <i class="bi bi-box-seam text-primary" style="font-size: 2rem;"></i>
                </div>
                <h5 class="fw-bold mb-3">100% Kualitas Original</h5>
                <p class="text-muted mb-0">Setiap buku yang kami kirimkan telah dijamin orisinalitasnya, mendatangkan karya langsung dari penerbit resmi bebas bajakan.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4 text-center" style="transition: transform 0.3s; cursor: pointer;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="d-inline-flex justify-content-center align-items-center mb-4" style="width: 70px; height: 70px; background: #ecfdf5; border-radius: 50%;">
                    <i class="bi bi-qr-code-scan text-success" style="font-size: 2rem;"></i>
                </div>
                <h5 class="fw-bold mb-3">Sistem Pembayaran QRIS</h5>
                <p class="text-muted mb-0">Kemudahan transaksi di ujung jari Anda. Kami mendukung penuh pembayaran instan dan aman menggunakan kode QRIS secara praktis!</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4 text-center" style="transition: transform 0.3s; cursor: pointer;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="d-inline-flex justify-content-center align-items-center mb-4" style="width: 70px; height: 70px; background: #fffbeb; border-radius: 50%;">
                    <i class="bi bi-tags text-warning" style="font-size: 2rem;"></i>
                </div>
                <h5 class="fw-bold mb-3">Harga Paling Menguntungkan</h5>
                <p class="text-muted mb-0">Koleksi berkualitas kini tidak harus mahal. Temukan selalu diskon ekstra dan promo spesial hanya untuk konsumen setia kami.</p>
            </div>
        </div>
    </div>
</div>

{{-- Call to Action Card --}}
<div class="container my-5 pb-4">
    <div class="rounded-4 overflow-hidden position-relative shadow-lg" style="background: linear-gradient(135deg, #1e1b4b, #4338ca); padding: 5rem 2rem;">
        {{-- Custom abstract background shapes --}}
        <div style="position: absolute; width: 300px; height: 300px; background: rgba(255,255,255,0.05); border-radius: 50%; top: -100px; right: -50px; pointer-events: none;"></div>
        <div style="position: absolute; width: 200px; height: 200px; background: rgba(255,255,255,0.02); border-radius: 50%; bottom: -50px; left: 10%; pointer-events: none;"></div>
        
        <div class="row position-relative" style="z-index: 2;">
            <div class="col-lg-8 mx-auto text-center">
                <span class="badge bg-warning text-dark mb-3 px-3 py-2 fw-bold" style="border-radius: 20px;">Katalog Buku Dibuka</span>
                <h2 class="text-white fw-bold mb-3" style="font-size: 2.5rem; line-height: 1.3;">Siap Mengeksplorasi Ribuan<br>Karya Terbaik Kami?</h2>
                <p class="text-white-50 mb-5 fs-5">Mulai dari fiksi, pemrograman, hingga karya best-seller. Semuanya siap untuk Anda masukkan ke keranjang belanja Anda.</p>
                <a href="{{ route('books.index') }}" class="btn btn-lg px-5 py-3 fw-bold shadow" style="background: #fbbf24; border: none; color: #1f2937; border-radius: 50px; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                    Yuk Jelajahi Buku-Buku Kami! <i class="bi bi-arrow-right ms-2 border border-dark rounded-circle px-1 py-0"></i>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
