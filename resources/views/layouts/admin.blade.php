<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title', 'Dashboard') | Toko Buku</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        :root { --primary: #4f46e5; --sidebar-w: 260px; }

        body { background: #f1f5f9; }

        .sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
            position: fixed;
            top: 0; left: 0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 20px rgba(0,0,0,0.15);
        }

        .sidebar-brand {
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }

        .sidebar-brand h5 {
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
            margin: 0;
        }

        .sidebar-brand span { color: #818cf8; font-size: 0.75rem; }

        .sidebar-menu { padding: 1rem 0.75rem; flex: 1; }

        .menu-label {
            color: rgba(255,255,255,0.35);
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 0.75rem 0.5rem 0.25rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.6rem 0.875rem;
            border-radius: 10px;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
            margin-bottom: 2px;
        }

        .sidebar-link:hover, .sidebar-link.active {
            background: rgba(99,102,241,0.2);
            color: #a5b4fc;
        }

        .sidebar-link.active { background: rgba(99,102,241,0.3); color: #c7d2fe; }
        .sidebar-link i { font-size: 1rem; width: 18px; }

        .badge-menu {
            margin-left: auto;
            background: #ef4444;
            color: #fff;
            font-size: 0.65rem;
            padding: 2px 7px;
            border-radius: 20px;
        }

        .main-content {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
        }

        .top-bar {
            background: #fff;
            padding: 0.875rem 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 8px rgba(0,0,0,0.05);
        }

        .content-area { padding: 1.5rem; }

        /* Cards */
        .stat-card {
            border: none;
            border-radius: 16px;
            padding: 1.25rem;
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: -20px; right: -20px;
            width: 80px; height: 80px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
        }

        .stat-number { font-size: 2rem; font-weight: 700; line-height: 1; }
        .stat-label { font-size: 0.78rem; opacity: 0.85; margin-top: 0.25rem; }

        /* Tables */
        .table-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .table-card .table { margin: 0; }
        .table-card .table th {
            background: #f8fafc;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            border: none;
            padding: 0.875rem 1rem;
        }

        .table-card .table td {
            padding: 0.875rem 1rem;
            vertical-align: middle;
            font-size: 0.875rem;
            border-color: #f1f5f9;
        }

        .page-header {
            background: #fff;
            border-radius: 16px;
            padding: 1.25rem 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.04);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .page-header h4 { margin: 0; font-weight: 700; color: #0f172a; }

        .form-card {
            background: #fff;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .form-label { font-size: 0.85rem; font-weight: 600; color: #374151; }
        .form-control, .form-select {
            border-radius: 10px;
            border-color: #e2e8f0;
            font-size: 0.875rem;
            padding: 0.6rem 0.875rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
        }

        .btn-primary { background: #4f46e5; border-color: #4f46e5; border-radius: 10px; font-weight: 600; font-size: 0.875rem; }
        .btn-primary:hover { background: #3730a3; border-color: #3730a3; }
        .badge { border-radius: 20px; font-weight: 500; }
        .alert { border: none; border-radius: 12px; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .main-content { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>

<div class="sidebar">
    <div class="sidebar-brand">
        <h5><i class="bi bi-book-half me-2"></i>Toko Buku Admin</h5>
        <span>Panel Manajemen</span>
    </div>

    <div class="sidebar-menu">
        <div class="menu-label">Utama</div>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="menu-label">Katalog</div>
        <a href="{{ route('admin.categories.index') }}" class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <i class="bi bi-tags"></i> Kategori
        </a>
        <a href="{{ route('admin.books.index') }}" class="sidebar-link {{ request()->routeIs('admin.books.*') ? 'active' : '' }}">
            <i class="bi bi-book"></i> Buku
        </a>
        <a href="{{ route('admin.carousels.index') }}" class="sidebar-link {{ request()->routeIs('admin.carousels.*') ? 'active' : '' }}">
            <i class="bi bi-images"></i> Banner/Carousel
        </a>

        <div class="menu-label">Transaksi</div>
        <a href="{{ route('admin.orders.index') }}" class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="bi bi-bag-check"></i> Pesanan
        </a>
        <a href="{{ route('admin.payments.index') }}" class="sidebar-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
            <i class="bi bi-credit-card"></i> Pembayaran
            @php $pendingPay = \App\Models\PaymentProof::where('status','pending')->count(); @endphp
            @if($pendingPay > 0)
                <span class="badge-menu">{{ $pendingPay }}</span>
            @endif
        </a>

        <div class="menu-label">Pengguna</div>
        <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Manajemen User
        </a>

        <div class="menu-label mt-3">Toko</div>
        <a href="{{ route('home') }}" class="sidebar-link" target="_blank">
            <i class="bi bi-shop"></i> Lihat Toko
        </a>
    </div>

    <div class="p-3 border-top" style="border-color: rgba(255,255,255,0.07) !important;">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="sidebar-link w-100 border-0 bg-transparent text-start">
                <i class="bi bi-box-arrow-left"></i> Logout
            </button>
        </form>
    </div>
</div>

<div class="main-content">
    <div class="top-bar">
        <div>
            <span class="fw-semibold text-dark" style="font-size: 0.9rem;">@yield('page-title', 'Dashboard')</span>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-primary">Admin</span>
            <span style="font-size: 0.85rem; color: #64748b;">{{ auth()->user()->name }}</span>
        </div>
    </div>

    <div class="content-area">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible shadow-sm mb-3">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible shadow-sm mb-3">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
