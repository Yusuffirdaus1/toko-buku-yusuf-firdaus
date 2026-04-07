@extends('layouts.admin')
@section('title','Tambah Banner')
@section('page-title','Tambah Banner')

@section('content')
<div class="page-header">
    <h4>Tambah Banner/Carousel</h4>
    <a href="{{ route('admin.carousels.index') }}" class="btn btn-outline-secondary rounded-3"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
</div>
<div class="form-card">
    @if($errors->any())
        <div class="alert alert-danger">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
    @endif
    <form action="{{ route('admin.carousels.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label">Judul</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Tipe</label>
                <select name="type" class="form-select" required>
                    <option value="main" {{ old('type') === 'main' ? 'selected' : '' }}>Main (Hero)</option>
                    <option value="promo" {{ old('type') === 'promo' ? 'selected' : '' }}>Promo Banner</option>
                </select>
            </div>
            <div class="col-12">
                <label class="form-label">Deskripsi</label>
                <input type="text" name="description" class="form-control" value="{{ old('description') }}" placeholder="Teks subtitle banner">
            </div>
            <div class="col-md-8">
                <label class="form-label">Gambar Banner</label>
                <input type="file" name="image_path" class="form-control" accept="image/*" required onchange="previewImg(this)">
                <img id="imgPreview" class="mt-2 rounded-3 d-none" style="max-height: 150px; object-fit: cover; width: 100%;">
            </div>
            <div class="col-md-4">
                <label class="form-label">Urutan</label>
                <input type="number" name="order" class="form-control" value="{{ old('order', 0) }}" min="0">
            </div>
            <div class="col-md-8">
                <label class="form-label">Link (opsional)</label>
                <input type="url" name="link" class="form-control" value="{{ old('link') }}" placeholder="https://...">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <div class="form-check mb-2">
                    <input type="checkbox" class="form-check-input" name="is_active" id="isActive" value="1" checked>
                    <label class="form-check-label" for="isActive">Aktif/Tampil</label>
                </div>
            </div>
        </div>
        <hr class="my-4">
        <button type="submit" class="btn btn-primary px-4">Simpan Banner</button>
    </form>
</div>
@push('scripts')
<script>
function previewImg(input) {
    const img = document.getElementById('imgPreview');
    if (input.files?.[0]) { img.src = URL.createObjectURL(input.files[0]); img.classList.remove('d-none'); }
}
</script>
@endpush
@endsection
