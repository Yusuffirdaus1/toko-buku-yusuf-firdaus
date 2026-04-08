@extends('layouts.admin')
@section('title', 'Riwayat Pendapatan')
@section('page-title', 'Riwayat Pendapatan')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-3">
    <h4><i class="bi bi-cash-coin me-2"></i>Riwayat Pendapatan</h4>
</div>

<div class="row g-4 mb-4">
    <div class="col-12 col-md-4">
        <div class="card border-0 shadow-sm rounded-4 text-white p-4" style="background: linear-gradient(135deg, #4f46e5, #0ea5e9);">
            <div class="d-flex align-items-center mb-3">
                <i class="bi bi-wallet2 fs-2 me-3 opacity-75"></i>
                <div>
                    <h6 class="mb-0 opacity-75 fw-medium">Total Pendapatan Valid</h6>
                    <small>(Pesanan Batal Tidak Dihitung)</small>
                </div>
            </div>
            <h2 class="fw-bold mb-0">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
        </div>
    </div>
    
    <div class="col-12 col-md-8">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
            <h6 class="fw-bold mb-3"><i class="bi bi-funnel me-2"></i>Filter Rentang Waktu</h6>
            <form action="{{ route('admin.revenue.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small text-muted">Tanggal Mulai</label>
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label small text-muted">Tanggal Akhir</label>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary d-flex-fill w-100 fw-medium">Terapkan Filter</button>
                    @if(request('start_date') || request('end_date'))
                        <a href="{{ route('admin.revenue.index') }}" class="btn btn-light border w-100 fw-medium">Reset</a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

<div class="table-card">
    <div class="p-3 border-bottom">
        <h6 class="fw-bold mb-0">Daftar Transaksi Valid</h6>
        <p class="text-muted small mb-0 mt-1">Hanya menampilkan pesanan yang sudah Dikonfirmasi, Dikirim, atau Selesai.</p>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th># Order</th>
                    <th>Pelanggan</th>
                    <th>Tanggal Order</th>
                    <th>Pembayaran</th>
                    <th>Status</th>
                    <th class="text-end">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="fw-bold text-primary text-decoration-none">#{{ $order->id }}</a>
                        </td>
                        <td>
                            <p class="mb-0 fw-semibold">{{ $order->user->name }}</p>
                            <small class="text-muted">{{ $order->user->email }}</small>
                        </td>
                        <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ strtoupper($order->payment_method) }}</span>
                        </td>
                        <td>{!! $order->status_badge !!}</td>
                        <td class="text-end fw-bold text-success">
                            {{ $order->formatted_total }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted border-bottom-0">Belum ada catatan pendapatan untuk rentang waktu ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($orders->hasPages())
        <div class="p-3 bg-light border-top">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
