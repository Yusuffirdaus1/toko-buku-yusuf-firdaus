@extends('layouts.admin')
@section('title','Banner/Carousel')
@section('page-title','Banner & Carousel')

@section('content')
<div class="page-header">
    <h4><i class="bi bi-images me-2"></i>Banner & Carousel</h4>
    <a href="{{ route('admin.carousels.create') }}" class="btn btn-primary rounded-3">
        <i class="bi bi-plus me-1"></i>Tambah Banner
    </a>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>Preview</th><th>Judul</th><th>Tipe</th><th>Urutan</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($carousels as $car)
                    <tr>
                        <td><img src="{{ $car->image_url }}" width="80" height="50" style="object-fit: cover; border-radius: 6px;"></td>
                        <td>
                            <p class="fw-semibold mb-0 small">{{ $car->title }}</p>
                            @if($car->link)<small class="text-muted">{{ Str::limit($car->link, 30) }}</small>@endif
                        </td>
                        <td>
                            <span class="badge {{ $car->type === 'main' ? 'bg-primary' : 'bg-warning text-dark' }}">
                                {{ ucfirst($car->type) }}
                            </span>
                        </td>
                        <td>{{ $car->order }}</td>
                        <td>
                            <span class="badge {{ $car->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $car->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.carousels.edit', $car) }}" class="btn btn-sm btn-outline-primary rounded-3 me-1"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.carousels.destroy', $car) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger rounded-3" onclick="return confirm('Hapus banner?')"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Belum ada banner</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $carousels->links() }}</div>
</div>
@endsection
