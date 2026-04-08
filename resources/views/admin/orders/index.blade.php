@extends('layouts.admin')
@section('title','Semua Pesanan')
@section('page-title','Manajemen Pesanan')

@section('content')
<div class="page-header">
    <h4><i class="bi bi-bag-check me-2"></i>Semua Pesanan</h4>
    <form class="d-flex gap-2">
        <select name="status" class="form-select form-select-sm rounded-3 fw-medium" style="min-width: 140px; cursor: pointer;" onchange="this.form.submit()">
            <option value="">Semua Status</option>
            @foreach(['pending','confirmed','shipped','completed','cancelled'] as $s)
                <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
    </form>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>#</th><th>Pelanggan</th><th>Total</th><th>Status</th><th>Pembayaran</th><th>Tanggal</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>
                            <p class="fw-semibold mb-0 small">{{ $order->user->name }}</p>
                            <small class="text-muted">{{ $order->user->email }}</small>
                        </td>
                        <td class="fw-semibold">{{ $order->formatted_total }}</td>
                        <td>{!! $order->status_badge !!}</td>
                        <td>
                            @if(in_array($order->status, ['confirmed', 'shipped', 'completed']))
                                <span class="badge bg-success">Lunas (QRIS)</span>
                            @elseif($order->status === 'cancelled')
                                <span class="badge bg-danger">Batal</span>
                            @else
                                <span class="badge bg-warning text-dark">Belum Lunas (QRIS)</span>
                            @endif
                        </td>
                        <td class="text-muted small">{{ $order->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary rounded-3">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Belum ada pesanan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $orders->links() }}</div>
</div>
@endsection
