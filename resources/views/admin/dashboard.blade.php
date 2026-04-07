@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
{{-- Stats Cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#4f46e5,#818cf8);">
            <i class="bi bi-people-fill" style="font-size: 1.5rem; opacity: 0.7;"></i>
            <div class="stat-number mt-1">{{ $stats['users'] }}</div>
            <div class="stat-label">Total User</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#f97316,#fb923c);">
            <i class="bi bi-book-fill" style="font-size: 1.5rem; opacity: 0.7;"></i>
            <div class="stat-number mt-1">{{ $stats['books'] }}</div>
            <div class="stat-label">Total Buku</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#10b981,#34d399);">
            <i class="bi bi-bag-check-fill" style="font-size: 1.5rem; opacity: 0.7;"></i>
            <div class="stat-number mt-1">{{ $stats['orders'] }}</div>
            <div class="stat-label">Total Pesanan</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#06b6d4,#22d3ee);">
            <i class="bi bi-currency-dollar" style="font-size: 1.5rem; opacity: 0.7;"></i>
            <div class="stat-number mt-1" style="font-size: 1.3rem;">{{ number_format($stats['revenue']/1000000, 1) }}Jt</div>
            <div class="stat-label">Total Pendapatan</div>
        </div>
    </div>
</div>

{{-- Alert Badges --}}
@if($stats['pending_orders'] > 0 || $stats['unread_messages'] > 0)
<div class="row g-3 mb-4">
    @if($stats['pending_orders'] > 0)
        <div class="col-md-4">
            <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-3 p-3 border-start border-warning border-3">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-warning text-dark fs-5">{{ $stats['pending_orders'] }}</span>
                        <span class="fw-semibold small">Pesanan Pending</span>
                    </div>
                </div>
            </a>
        </div>
    @endif

    @if($stats['unread_messages'] > 0)
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 p-3 border-start border-info border-3">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-info fs-5">{{ $stats['unread_messages'] }}</span>
                    <span class="fw-semibold small">Pesan Belum Dibaca</span>
                </div>
            </div>
        </div>
    @endif
</div>
@endif

<div class="row g-4">
    {{-- Recent Orders --}}
    <div class="col-lg-7">
        <div class="table-card">
            <div class="p-3 border-bottom d-flex align-items-center justify-content-between">
                <h6 class="fw-bold mb-0">Pesanan Terbaru</h6>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3" style="font-size: 0.78rem;">Lihat Semua</a>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th><th>Pelanggan</th><th>Total</th><th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $order->formatted_total }}</td>
                            <td>{!! $order->status_badge !!}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">Belum ada pesanan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Recent Messages --}}
    <div class="col-lg-5">
        <div class="table-card">
            <div class="p-3 border-bottom">
                <h6 class="fw-bold mb-0">Pesan Terbaru</h6>
            </div>
            <div class="p-3">
                @forelse($recentMessages as $msg)
                    <div class="mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="fw-semibold small">{{ $msg->name }}</span>
                            <small class="text-muted">{{ $msg->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="text-muted mb-0" style="font-size: 0.78rem;">{{ Str::limit($msg->message, 80) }}</p>
                    </div>
                @empty
                    <p class="text-center text-muted py-3 mb-0">Belum ada pesan</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
