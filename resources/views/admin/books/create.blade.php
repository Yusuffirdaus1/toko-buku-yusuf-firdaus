@extends('layouts.admin')
@section('title','Tambah Buku')
@section('page-title','Tambah Buku')

@section('content')
<div class="page-header">
    <h4>Tambah Buku Baru</h4>
    <a href="{{ route('admin.books.index') }}" class="btn btn-outline-secondary rounded-3"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
</div>
<div class="form-card">
    @if($errors->any())
        <div class="alert alert-danger">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
    @endif
    <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label">Judul Buku</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Kategori</label>
                <select name="category_id" class="form-select" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Penulis</label>
                <input type="text" name="author" class="form-control" value="{{ old('author') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Penerbit</label>
                <input type="text" name="publisher" class="form-control" value="{{ old('publisher') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Harga (Rp)</label>
                <input type="number" name="price" class="form-control" value="{{ old('price') }}" min="0" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Stok</label>
                <input type="number" name="stock" class="form-control" value="{{ old('stock', 0) }}" min="0" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Tahun Terbit</label>
                <input type="number" name="year" class="form-control" value="{{ old('year') }}" min="1900" max="{{ date('Y') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">ISBN</label>
                <input type="text" name="isbn" class="form-control" value="{{ old('isbn') }}">
            </div>
            <div class="col-md-8">
                <label class="form-label">Cover Buku</label>
                <input type="file" name="cover_image" class="form-control" accept="image/*" onchange="previewCover(this)">
                <img id="coverPreview" class="mt-2 rounded-3 d-none" style="height: 120px; object-fit: cover;">
            </div>
            <div class="col-12">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
            </div>
        </div>
        <hr class="my-4">
        <button type="submit" class="btn btn-primary px-4">Simpan Buku</button>
    </form>
</div>
@push('scripts')
<script>
function previewCover(input) {
    const img = document.getElementById('coverPreview');
    if (input.files?.[0]) { img.src = URL.createObjectURL(input.files[0]); img.classList.remove('d-none'); }
}
</script>
@endpush
@endsection
