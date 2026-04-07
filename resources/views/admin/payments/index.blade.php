@extends('layouts.admin')
@section('title','Pembayaran')
@section('page-title','Manajemen Pembayaran')

@section('content')
<div class="page-header">
    <h4><i class="bi bi-credit-card me-2"></i>Bukti Pembayaran</h4>
    <form class="d-flex gap-2">
        <select name="status" class="form-select form-select-sm rounded-3" onchange="this.form.submit()">
            <option value="">Semua Status</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
        </select>
    </form>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>#</th><th>Pelanggan</th><th>Pesanan</th><th>Total</th><th>Status</th><th>Dikirim</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($payments as $payment)
                    <tr>
                        <td>{{ $payment->id }}</td>
                        <td class="small fw-semibold">{{ $payment->order->user->name }}</td>
                        <td><a href="{{ route('admin.orders.show', $payment->order) }}" class="text-primary">#{{ $payment->order_id }}</a></td>
                        <td class="small fw-semibold">{{ $payment->order->formatted_total }}</td>
                        <td>
                            <span class="badge {{ $payment->status === 'confirmed' ? 'bg-success' : ($payment->status === 'rejected' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </td>
                        <td class="text-muted small">{{ $payment->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('admin.payments.show', $payment) }}" class="btn btn-sm btn-outline-primary rounded-3">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Belum ada pembayaran</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $payments->links() }}</div>
</div>
@endsection
