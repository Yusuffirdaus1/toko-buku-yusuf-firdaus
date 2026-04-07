@extends('layouts.admin')
@section('title','Kategori')
@section('page-title','Kategori Buku')

@section('content')
<div class="page-header">
    <h4><i class="bi bi-tags me-2"></i>Kategori Buku</h4>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary rounded-3">
        <i class="bi bi-plus me-1"></i>Tambah Kategori
    </a>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr><th>#</th><th>Nama</th><th>Slug</th><th>Deskripsi</th><th>Buku</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                    <tr>
                        <td>{{ $cat->id }}</td>
                        <td class="fw-semibold">{{ $cat->name }}</td>
                        <td><code>{{ $cat->slug }}</code></td>
                        <td class="text-muted small">{{ Str::limit($cat->description, 60) ?: '-' }}</td>
                        <td><span class="badge bg-primary">{{ $cat->books_count }}</span></td>
                        <td>
                            <a href="{{ route('admin.categories.edit', $cat) }}" class="btn btn-sm btn-outline-primary rounded-3 me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger rounded-3"
                                        onclick="return confirm('Hapus kategori? Pastikan tidak ada buku terkait.')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Belum ada kategori</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $categories->links() }}</div>
</div>
@endsection
