@extends('layouts.admin')

@section('title', 'Edit Produk: ' . $product->name)

@section('content')
<style>
    :root {
        --warning-gradient: linear-gradient(135deg, #f0932b 0%, #ffbe76 100%);
        --primary-gradient: linear-gradient(135deg, #4834d4 0%, #686de0 100%);
    }

    .card-custom {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        background: #fff;
    }

    .section-title {
        position: relative;
        padding-bottom: 10px;
        margin-bottom: 25px;
        font-weight: 700;
        color: #1e293b;
    }

    .section-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 40px;
        height: 4px;
        background: var(--warning-gradient);
        border-radius: 2px;
    }

    .form-label {
        font-weight: 600;
        color: #475569;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-control, .form-select {
        border-radius: 12px;
        padding: 0.75rem 1rem;
        border: 2px solid #f1f5f9;
        background-color: #f8fafc;
        transition: 0.3s;
    }

    .form-control:focus, .form-select:focus {
        border-color: #f0932b;
        box-shadow: 0 0 0 4px rgba(240, 147, 43, 0.1);
        background-color: #fff;
    }

    /* Styling Gambar */
    .image-card {
        border-radius: 15px;
        overflow: hidden;
        transition: 0.3s;
        border: 2px solid #f1f5f9;
    }

    .image-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .badge-primary-image {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(255, 255, 255, 0.9);
        padding: 5px 10px;
        border-radius: 8px;
        font-size: 0.7rem;
        font-weight: 700;
        color: #f0932b;
    }

    .btn-update {
        background: var(--warning-gradient);
        border: none;
        padding: 15px;
        border-radius: 15px;
        font-weight: 700;
        color: #fff;
        transition: 0.3s;
    }

    .btn-update:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(240, 147, 43, 0.3);
        color: #fff;
    }

    .bg-light-status {
        background-color: #f8fafc;
        border-radius: 15px;
        padding: 20px;
    }
</style>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="h3 mb-1 fw-bold text-dark">Edit Produk</h2>
                    <p class="text-muted small mb-0">Perbarui detail produk <strong>{{ $product->name }}</strong></p>
                </div>
                <a href="{{ route('admin.products.index') }}" class="btn btn-white shadow-sm px-4 fw-bold text-secondary" style="border-radius: 12px; border:none;">
                    <i class="bi bi-arrow-left me-2"></i> Kembali
                </a>
            </div>

            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- Kolom Kiri: Informasi Utama --}}
                    <div class="col-md-8">
                        <div class="card card-custom mb-4">
                            <div class="card-body p-4">
                                <h5 class="section-title">Informasi Produk</h5>
                                
                                <div class="mb-4">
                                    <label class="form-label">Nama Produk</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name', $product->name) }}" required>
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Kategori</label>
                                    <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-2">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea name="description" rows="6" class="form-control" placeholder="Tuliskan deskripsi lengkap produk...">{{ old('description', $product->description) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="card card-custom mb-4">
                            <div class="card-body p-4">
                                <h5 class="section-title">Harga & Logistik</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Harga Normal (Rp)</label>
                                        <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Harga Diskon (Rp)</label>
                                        <input type="number" name="discount_price" class="form-control" value="{{ old('discount_price', $product->discount_price) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Stok Barang</label>
                                        <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Berat (Gram)</label>
                                        <input type="number" name="weight" class="form-control" value="{{ old('weight', $product->weight) }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Kolom Kanan: Status & Gambar --}}
                    <div class="col-md-4">
                        <div class="card card-custom mb-4">
                            <div class="card-body p-4">
                                <h5 class="section-title">Status</h5>
                                <div class="bg-light-status mb-3">
                                    <div class="form-check form-switch d-flex justify-content-between align-items-center ps-0 mb-3">
                                        <label class="fw-bold text-dark mb-0">Tampilkan Produk</label>
                                        <input class="form-check-input fs-5" type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                    </div>
                                    <div class="form-check form-switch d-flex justify-content-between align-items-center ps-0">
                                        <label class="fw-bold text-dark mb-0">Produk Unggulan</label>
                                        <input class="form-check-input fs-5" type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-update w-100 shadow-sm">
                                    <i class="bi bi-cloud-check me-2"></i> Update Produk
                                </button>
                            </div>
                        </div>

                        <div class="card card-custom">
                            <div class="card-body p-4">
                                <h5 class="section-title">Media & Foto</h5>
                                <div class="mb-4">
                                    <label class="form-label">Tambah Foto Baru</label>
                                    <input type="file" name="images[]" class="form-control" multiple>
                                </div>

                                <label class="form-label mb-3">Kelola Foto Saat Ini</label>
                                <div class="row g-2">
                                    @foreach($product->images as $image)
                                        <div class="col-6">
                                            <div class="image-card position-relative h-100 bg-light">
                                                @if($image->is_primary)
                                                    <span class="badge-primary-image shadow-sm"><i class="bi bi-star-fill me-1"></i>Utama</span>
                                                @endif
                                                <img src="{{ asset('storage/'.$image->image_path) }}" class="w-100" style="height: 120px; object-fit: cover;">
                                                <div class="p-2">
                                                    <div class="form-check mb-1">
                                                        <input class="form-check-input" type="radio" name="primary_image" value="{{ $image->id }}" {{ $image->is_primary ? 'checked' : '' }}>
                                                        <label class="small fw-bold">Jadikan Utama</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="delete_images[]" value="{{ $image->id }}">
                                                        <label class="small text-danger fw-bold">Hapus</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection