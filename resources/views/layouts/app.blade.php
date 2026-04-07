<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Toko Buku Yusuf Firdaus - Temukan buku favorit Anda dengan harga terbaik">
    <title>@yield('title', 'Toko Buku Yusuf Firdaus')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #3730a3;
            --secondary: #f97316;
            --accent: #06b6d4;
            --dark: #0f172a;
            --light-bg: #f8fafc;
        }

        * { font-family: 'Poppins', sans-serif; }

        body { background-color: var(--light-bg); color: var(--dark); }

        /* Navbar */
        .navbar-main {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            box-shadow: 0 4px 20px rgba(79,70,229,0.3);
            padding: 0.75rem 0;
        }

        .navbar-main .navbar-brand {
            font-size: 1.4rem;
            font-weight: 700;
            color: #fff !important;
            letter-spacing: -0.5px;
        }

        .navbar-main .nav-link {
            color: rgba(255,255,255,0.85) !important;
            font-weight: 500;
            padding: 0.4rem 0.9rem !important;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .navbar-main .nav-link:hover,
        .navbar-main .nav-link.active {
            color: #fff !important;
            background: rgba(255,255,255,0.15);
        }

        .cart-badge {
            background: var(--secondary);
            color: #fff;
            font-size: 0.65rem;
            padding: 2px 6px;
            border-radius: 20px;
            font-weight: 600;
        }

        /* Hero Carousel */
        .hero-carousel .carousel-item img {
            height: 420px;
            object-fit: cover;
            border-radius: 0 0 20px 20px;
        }

        /* Book Cards */
        .book-card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            background: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        }

        .book-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 30px rgba(79,70,229,0.15);
        }

        .book-card .card-img-top {
            height: 220px;
            object-fit: cover;
        }

        .book-card .card-body { padding: 1rem; }

        .book-card .book-title {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--dark);
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .book-card .book-author {
            font-size: 0.78rem;
            color: #64748b;
        }

        .book-card .book-price {
            font-weight: 700;
            font-size: 1rem;
            color: var(--primary);
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border: none;
            border-radius: 10px;
            padding: 0.5rem 1.2rem;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.3s;
            color: #fff;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79,70,229,0.4);
            color: #fff;
        }

        /* Section Headers */
        .section-title {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--dark);
            position: relative;
            padding-bottom: 0.5rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: var(--primary);
            border-radius: 3px;
        }

        /* Footer */
        footer {
            background: var(--dark);
            color: rgba(255,255,255,0.7);
        }

        footer a { color: rgba(255,255,255,0.7); text-decoration: none; }
        footer a:hover { color: #fff; }

        /* Alerts */
        .alert { border: none; border-radius: 12px; font-size: 0.9rem; }

        /* Badge */
        .badge-stock-ok { background: #dcfce7; color: #166534; font-size: 0.72rem; padding: 4px 10px; border-radius: 20px; }
        .badge-stock-empty { background: #fee2e2; color: #991b1b; font-size: 0.72rem; padding: 4px 10px; border-radius: 20px; }

        /* Category Pills */
        .category-pill {
            display: inline-block;
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.82rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }

        .category-pill.active, .category-pill:hover {
            background: var(--primary);
            color: #fff;
        }

        .category-pill:not(.active) {
            background: #e0e7ff;
            color: var(--primary);
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-thumb { background: var(--primary); border-radius: 3px; }

        /* WhatsApp Floating Button */
        .wa-floating {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background-color: #25d366;
            color: white;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            box-shadow: 0 4px 15px rgba(37, 211, 102, 0.4);
            z-index: 1000;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .wa-floating:hover {
            transform: scale(1.1) translateY(-5px);
            box-shadow: 0 6px 20px rgba(37, 211, 102, 0.6);
            color: white;
        }
    </style>

    @stack('styles')
</head>
<body>

{{-- Navbar --}}
<nav class="navbar navbar-main navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="bi bi-book-half me-2"></i>Toko Buku
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
            <i class="bi bi-list text-white fs-4"></i>
        </button>

        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav me-auto ms-3">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('books.*') ? 'active' : '' }}" href="{{ route('books.index') }}">Katalog Buku</a>
                </li>
            </ul>

            <ul class="navbar-nav align-items-center gap-1">
                @auth
                    @if(auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-speedometer2 me-1"></i>Dashboard Admin
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cart.index') }}">
                                <i class="bi bi-cart3 me-1"></i>Keranjang
                                @php $cartCount = auth()->user()->carts()->count(); @endphp
                                @if($cartCount > 0)
                                    <span class="cart-badge">{{ $cartCount }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('orders.index') }}">
                                <i class="bi bi-receipt me-1"></i>Pesanan
                            </a>
                        </li>
                    @endif

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Masuk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-sm ms-2 text-white" href="{{ route('register') }}"
                           style="background: var(--secondary); border-radius: 8px; padding: 0.4rem 1rem; font-weight: 600;">
                            Daftar
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

{{-- Flash Messages --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible m-3 shadow-sm" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible m-3 shadow-sm" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('info'))
    <div class="alert alert-info alert-dismissible m-3 shadow-sm" role="alert">
        <i class="bi bi-info-circle-fill me-2"></i>{{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Main Content --}}
<main>
    @yield('content')
</main>

{{-- Footer --}}
<footer class="py-5 mt-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <h5 class="text-white fw-bold mb-3"><i class="bi bi-book-half me-2"></i>Toko Buku Yusuf Firdaus</h5>
                <p style="font-size: 0.88rem;">Temukan koleksi buku terlengkap dengan harga terjangkau. Pengiriman ke seluruh Indonesia.</p>
            </div>
            <div class="col-md-2">
                <h6 class="text-white fw-semibold mb-3">Navigasi</h6>
                <ul class="list-unstyled" style="font-size: 0.88rem;">
                    <li class="mb-1"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="mb-1"><a href="{{ route('books.index') }}">Katalog</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h6 class="text-white fw-semibold mb-3">Akun</h6>
                <ul class="list-unstyled" style="font-size: 0.88rem;">
                    @auth
                        <li class="mb-1"><a href="{{ route('orders.index') }}">Pesanan Saya</a></li>
                    @else
                        <li class="mb-1"><a href="{{ route('login') }}">Masuk</a></li>
                        <li class="mb-1"><a href="{{ route('register') }}">Daftar</a></li>
                    @endauth
                </ul>
            </div>
            <div class="col-md-3">
                <h6 class="text-white fw-semibold mb-3">Kontak</h6>
                <p style="font-size: 0.88rem;">
                    <i class="bi bi-envelope me-2"></i>tokobuku@example.com<br>
                    <i class="bi bi-telephone me-2"></i>088289188861<br>
                    <i class="bi bi-geo-alt me-2"></i>Indonesia
                </p>
            </div>
        </div>
        <hr class="border-secondary mt-4">
        <p class="text-center mb-0" style="font-size: 0.82rem;">
            &copy; {{ date('Y') }} Toko Buku Yusuf Firdaus. All rights reserved.
        </p>
    </div>
</footer>

{{-- WhatsApp Floating Button --}}
<a href="https://wa.me/6288289188861?text=Halo%20Admin%20Toko%20Buku%20Yusuf%20Firdaus,%20saya%20ingin%20bertanya%20seputar%20buku..." target="_blank" class="wa-floating" title="Hubungi Kami via WhatsApp">
    <i class="bi bi-whatsapp"></i>
</a>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')
</body>
</html>
