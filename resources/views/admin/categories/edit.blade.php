@extends('layouts.admin')
@section('title','Edit Kategori')
@section('page-title','Edit Kategori')

@section('content')
<div class="page-header">
    <h4>Edit Kategori: {{ $category->name }}</h4>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary rounded-3"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
</div>
<div class="form-card">
    @if($errors->any())
        <div class="alert alert-danger">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
    @endif
    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label">Nama Kategori</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
        </div>
        <div class="mb-4">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary px-4">Update Kategori</button>
    </form>
</div>
@endsection
