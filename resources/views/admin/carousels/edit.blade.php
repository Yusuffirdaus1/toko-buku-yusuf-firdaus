@extends('layouts.admin')
@section('title','Edit Banner')
@section('page-title','Edit Banner')

@section('content')
<div class="page-header">
    <h4>Edit Banner: {{ $carousel->title }}</h4>
    <a href="{{ route('admin.carousels.index') }}" class="btn btn-outline-secondary rounded-3"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
</div>
<div class="form-card">
    @if($errors->any())
        <div class="alert alert-danger">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
    @endif
    <form action="{{ route('admin.carousels.update', $carousel) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label">Judul</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $carousel->title) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Tipe</label>
                <select name="type" class="form-select">
                    <option value="main" {{ $carousel->type === 'main' ? 'selected' : '' }}>Main (Hero)</option>
                    <option value="promo" {{ $carousel->type === 'promo' ? 'selected' : '' }}>Promo Banner</option>
                </select>
            </div>
            <div class="col-12">
                <label class="form-label">Deskripsi</label>
                <input type="text" name="description" class="form-control" value="{{ old('description', $carousel->description) }}">
            </div>
            <div class="col-md-8">
                <label class="form-label">Ganti Gambar (Kosongkan jika tidak diubah)</label>
                <input type="file" name="image_path" class="form-control" accept="image/*" onchange="previewImg(this)">
                <img id="imgPreview" src="{{ $carousel->image_url }}" class="mt-2 rounded-3" style="max-height: 120px; object-fit: cover; width: 100%;">
            </div>
            <div class="col-md-4">
                <label class="form-label">Urutan</label>
                <input type="number" name="order" class="form-control" value="{{ old('order', $carousel->order) }}" min="0">
            </div>
            <div class="col-md-8">
                <label class="form-label">Link (opsional)</label>
                <input type="url" name="link" class="form-control" value="{{ old('link', $carousel->link) }}">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <div class="form-check mb-2">
                    <input type="checkbox" class="form-check-input" name="is_active" id="isActive" value="1" {{ $carousel->is_active ? 'checked' : '' }}>
                    <label class="form-check-label" for="isActive">Aktif/Tampil</label>
                </div>
            </div>
        </div>
        <hr class="my-4">
        <button type="submit" class="btn btn-primary px-4">Update Banner</button>
    </form>
</div>
@push('scripts')
<script>
function previewImg(input) {
    const img = document.getElementById('imgPreview');
    if (input.files?.[0]) img.src = URL.createObjectURL(input.files[0]);
}
</script>
@endpush
@endsection
