@extends('layouts.admin')
@section('title','Tambah Kategori')
@section('page-title','Tambah Kategori')

@section('content')
<div class="page-header">
    <h4>Tambah Kategori Baru</h4>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary rounded-3"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
</div>
<div class="form-card">
    @if($errors->any())
        <div class="alert alert-danger">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
    @endif
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nama Kategori</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="Contoh: Fiksi, Non-Fiksi, Teknologi">
            <div class="form-text">Slug akan dibuat otomatis.</div>
        </div>
        <div class="mb-4">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" rows="3" placeholder="Deskripsi singkat kategori...">{{ old('description') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary px-4">Simpan Kategori</button>
    </form>
</div>
@endsection
