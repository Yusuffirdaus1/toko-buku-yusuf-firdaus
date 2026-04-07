@extends('layouts.admin')
@section('title','Manajemen Buku')
@section('page-title','Manajemen Buku')

@section('content')
<div class="page-header">
    <h4><i class="bi bi-book me-2"></i>Manajemen Buku</h4>
    <a href="{{ route('admin.books.create') }}" class="btn btn-primary rounded-3">
        <i class="bi bi-plus me-1"></i>Tambah Buku
    </a>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr><th>Cover</th><th>Judul</th><th>Kategori</th><th>Harga</th><th>Stok</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($books as $book)
                    <tr>
                        <td>
                            <img src="{{ $book->cover_url }}" width="40" height="52"
                                 style="object-fit: cover; border-radius: 6px;" alt="">
                        </td>
                        <td>
                            <p class="fw-semibold mb-0" style="font-size: 0.875rem;">{{ $book->title }}</p>
                            <small class="text-muted">{{ $book->author }}</small>
                        </td>
                        <td><span class="badge bg-light text-primary border border-primary">{{ $book->category->name }}</span></td>
                        <td class="fw-semibold">{{ $book->formatted_price }}</td>
                        <td>
                            <span class="{{ $book->stock > 0 ? 'badge-stock-ok' : 'badge-stock-empty' }}">
                                {{ $book->stock }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-sm btn-outline-primary rounded-3 me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger rounded-3"
                                        onclick="return confirm('Hapus buku ini?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Belum ada buku</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $books->links() }}</div>
</div>
@endsection
