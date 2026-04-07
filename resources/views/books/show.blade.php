@extends('layouts.app')
@section('title', $book->title . ' - Toko Buku')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('books.index') }}">Katalog</a></li>
            <li class="breadcrumb-item active">{{ Str::limit($book->title, 40) }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        {{-- Cover --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background-color: #f1f5f9; padding: 1rem;">
                <img src="{{ $book->cover_url }}" class="w-100" style="aspect-ratio: 2/3; object-fit: contain;" alt="{{ $book->title }}">
            </div>
        </div>

        {{-- Detail --}}
        <div class="col-md-8">
            <span class="badge text-primary border border-primary bg-light mb-2">{{ $book->category->name }}</span>
            <h1 class="h3 fw-bold">{{ $book->title }}</h1>
            <p class="text-muted mb-3">oleh <strong>{{ $book->author }}</strong>
                @if($book->publisher) &bull; {{ $book->publisher }} @endif
                @if($book->year) &bull; {{ $book->year }} @endif
            </p>

            <div class="d-flex align-items-center gap-3 mb-4">
                <span class="fw-bold" style="font-size: 1.8rem; color: #4f46e5;">{{ $book->formatted_price }}</span>
                @if($book->stock > 0)
                    <span class="badge-stock-ok fs-6"><i class="bi bi-check-circle me-1"></i>Tersedia ({{ $book->stock }} stok)</span>
                @else
                    <span class="badge-stock-empty fs-6">Stok Habis</span>
                @endif
            </div>

            @if($book->isbn)
                <p class="text-muted small mb-3"><i class="bi bi-upc me-1"></i>ISBN: {{ $book->isbn }}</p>
            @endif

            @if($book->description)
                <div class="mb-4">
                    <h6 class="fw-bold">Deskripsi Buku</h6>
                    <p class="text-muted" style="line-height: 1.8;">{{ $book->description }}</p>
                </div>
            @endif

            @auth
                @if(!auth()->user()->isAdmin())
                    @if($book->stock > 0)
                        <form action="{{ route('cart.store') }}" method="POST" class="d-flex gap-2 align-items-center">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                            <div class="input-group" style="max-width: 130px;">
                                <span class="input-group-text bg-white">Qty</span>
                                <input type="number" name="quantity" class="form-control" value="1"
                                       min="1" max="{{ $book->stock }}">
                            </div>
                            <button type="submit" class="btn btn-primary-custom px-4">
                                <i class="bi bi-cart-plus me-2"></i>Tambah ke Keranjang
                            </button>
                        </form>
                    @else
                        <button class="btn btn-secondary" disabled>Stok Habis</button>
                    @endif
                @endif
            @else
                <a href="{{ route('login') }}" class="btn btn-primary-custom px-4">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Login untuk Membeli
                </a>
            @endauth
        </div>
    </div>

    {{-- Related Books --}}
    @if($relatedBooks->isNotEmpty())
    <div class="mt-5">
        <h4 class="section-title mb-4">Buku Serupa</h4>
        <div class="row g-3">
            @foreach($relatedBooks as $rel)
                <div class="col-6 col-md-3">
                    <div class="book-card card h-100">
                        <a href="{{ route('books.show', $rel) }}" class="d-block" style="background-color: #f1f5f9; padding: 0.5rem;">
                            <img src="{{ $rel->cover_url }}" class="card-img-top w-100" style="aspect-ratio: 2/3; object-fit: contain;" alt="{{ $rel->title }}">
                        </a>
                        <div class="card-body p-3">
                            <p class="book-title mb-1">{{ $rel->title }}</p>
                            <p class="book-author small">{{ $rel->author }}</p>
                            <p class="book-price fw-bold" style="color: #4f46e5;">{{ $rel->formatted_price }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
