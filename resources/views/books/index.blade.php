@extends('layouts.app')
@section('title', 'Katalog Buku - Toko Buku Yusuf Firdaus')

@section('content')

{{-- Carousel Layout (Like screenshot) --}}
@if($mainCarousels->isNotEmpty() || $promoCarousels->isNotEmpty())
<div class="container mt-4 mb-4">
    <div class="row g-3">
        {{-- Main Carousel (col-lg-8) --}}
        <div class="{{ $promoCarousels->isNotEmpty() ? 'col-lg-8' : 'col-12' }}">
            @if($mainCarousels->isNotEmpty())
            <div id="heroCarousel" class="carousel slide h-100" data-bs-ride="carousel" style="border-radius: 20px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.08);">
                <div class="carousel-indicators">
                    @foreach($mainCarousels as $i => $banner)
                        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $i }}" class="{{ $i === 0 ? 'active' : '' }}"></button>
                    @endforeach
                </div>
                <div class="carousel-inner h-100">
                    @foreach($mainCarousels as $i => $banner)
                        <div class="carousel-item h-100 {{ $i === 0 ? 'active' : '' }}">
                            <div style="position: relative; width: 100%; height: clamp(250px, 30vw, 350px);">
                                <div style="position: absolute; top:0; left:0; width:100%; height:100%; background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0) 60%); z-index: 1;"></div>
                                <img src="{{ $banner->image_url }}" class="d-block w-100 h-100" style="object-fit: cover; object-position: center;" alt="{{ $banner->title }}">
                            </div>
                            <div class="carousel-caption d-none d-md-block" style="z-index: 2; bottom: 20px; text-shadow: 0 2px 4px rgba(0,0,0,0.8);">
                                <h3 class="fw-bold text-white mb-1">{{ $banner->title }}</h3>
                                @if($banner->description)
                                    <p class="mb-0 small">{{ $banner->description }}</p>
                                @endif
                                @if($banner->link)
                                    <a href="{{ $banner->link }}" class="btn btn-sm btn-warning fw-bold rounded-pill px-4 mt-2">Lihat Promo</a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
            @endif
        </div>

        {{-- Promo Carousels (col-lg-4) Stacked --}}
        @if($promoCarousels->isNotEmpty())
        <div class="col-lg-4 d-flex flex-column gap-3">
            @foreach($promoCarousels->take(2) as $promo)
            <a href="{{ $promo->link ?? '#' }}" class="d-block rounded-4 overflow-hidden position-relative shadow-sm flex-fill" 
               style="min-height: 160px; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                <div style="position: absolute; top:0; left:0; width:100%; height:100%; background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0) 70%); z-index: 1;"></div>
                <img src="{{ $promo->image_url }}" class="w-100 h-100 position-absolute top-0 start-0" style="object-fit: cover;">
                <div class="position-absolute bottom-0 start-0 p-3 w-100" style="z-index: 2;">
                    <span class="fw-semibold text-white d-block" style="font-size: 0.9rem;">{{ $promo->title }}</span>
                </div>
            </a>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endif

{{-- Full-width Search Bar matches screenshot --}}
<div class="container mb-4">
    <div class="card border-0 shadow-sm rounded-4 p-3">
        <form action="{{ route('books.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0"
                           placeholder="Cari buku berdasarkan judul atau penulis..." value="{{ request('search') }}" style="border-radius: 0 10px 10px 0;">
                </div>
            </div>
            <div class="col-md-3">
                <select name="category" class="form-select" style="border-radius: 10px;" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1 flex-grow-1">
                <button type="submit" class="btn w-100 text-white" style="background:#5a67d8; border-radius:10px;">
                    Cari Buku
                </button>
            </div>
            @auth
            <div class="col-md-2 text-end">
                <a href="{{ route('orders.index') }}" class="btn w-100 text-white" style="background:#10b981; border-radius:10px;">
                    <i class="bi bi-box-seam me-1"></i> Histori Pesanan
                </a>
            </div>
            @endauth
        </form>
    </div>
</div>

<div class="container pb-5">
    @if($books->isEmpty())
        <div class="text-center py-5 text-muted">
            <i class="bi bi-search" style="font-size: 3rem;"></i>
            <p class="mt-3 fw-semibold">Buku tidak ditemukan</p>
            <p class="small">Coba kata kunci atau kategori yang berbeda.</p>
        </div>
    @else
        <div class="row g-4">
            @foreach($books as $book)
                <div class="col-6 col-md-3">
                    <div class="book-card card h-100 border-0 shadow-sm" style="border-radius:15px; overflow:hidden;">
                        <a href="{{ $route = route('books.show', $book) }}" class="position-relative d-block" style="background-color: #f1f5f9; padding: 1rem;">
                            <img src="{{ $book->cover_url }}" class="card-img-top w-100" alt="{{ $book->title }}"
                                 style="aspect-ratio: 2/3; object-fit: contain;">
                            {{-- Badge Tersedia floating on top right --}}
                            @if($book->stock > 0)
                                <span class="badge position-absolute" style="top: 10px; right: 10px; background-color: #10b981; padding: 6px 12px; font-weight: 600;">Tersedia</span>
                            @else
                                <span class="badge position-absolute bg-danger" style="top: 10px; right: 10px; padding: 6px 12px; font-weight: 600;">Habis</span>
                            @endif
                        </a>
                        <div class="card-body p-3 d-flex flex-column">
                            <p class="text-muted small mb-1" style="font-size: 0.75rem;"><i class="bi bi-tag-fill me-1"></i>{{ $book->category->name }}</p>
                            <a href="{{ route('books.show', $book) }}" class="text-decoration-none text-dark">
                                <h6 class="fw-bold mb-1" style="font-size: 1rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $book->title }}</h6>
                            </a>
                            <p class="small text-muted mb-2">{{ $book->author }}</p>
                            <div class="mt-auto pt-2 border-top">
                                <span class="fw-bold" style="color: #4f46e5; font-size:1.1rem;">{{ $book->formatted_price }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $books->links() }}
        </div>
    @endif
</div>
@endsection
