@extends('layouts.admin')

@section('title', 'Detail: ' . $product->name)

@section('content')
<style>
    :root {
        --info-gradient: linear-gradient(135deg, #0984e3 0%, #74b9ff 100%);
    }

    .card-custom {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    .product-title {
        font-weight: 800;
        color: #2d3436;
        letter-spacing: -0.5px;
    }

    /* Gallery Styling */
    .main-image-container {
        border-radius: 20px;
        overflow: hidden;
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        transition: 0.3s;
    }

    .main-image-container img {
        transition: transform 0.5s ease;
    }

    .main-image-container:hover img {
        transform: scale(1.05);
    }

    .thumb-image {
        border-radius: 12px;
        cursor: pointer;
        transition: 0.3s;
        border: 2px solid transparent;
        object-fit: cover;
    }

    .thumb-image:hover {
        border-color: #0984e3;
        opacity: 0.8;
    }

    /* Price Tag */
    .price-wrapper {
        background: #f1f2f6;
        padding: 15px 25px;
        border-radius: 15px;
        display: inline-block;
    }

    /* Stats Card */
    .stat-card {
        background: #fff;
        border: 1px solid #f1f5f9;
        padding: 15px;
        border-radius: 15px;
        text-align: center;
        transition: 0.3s;
    }

    .stat-card:hover {
        border-color: #0984e3;
        background: #f0f7ff;
    }

    .stat-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        font-weight: 700;
        color: #636e72;
        display: block;
        margin-bottom: 5px;
    }

    .stat-value {
        font-weight: 700;
        color: #2d3436;
        font-size: 1.1rem;
    }

    .badge-custom {
        padding: 8px 16px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.8rem;
    }
</style>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-11">

            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-1">
                            <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}" class="text-decoration-none">Produk</a></li>
                            <li class="breadcrumb-item active">Detail</li>
                        </ol>
                    </nav>
                    <h2 class="h3 mb-0 fw-bold text-dark">Informasi Produk</h2>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-light shadow-sm px-4 fw-bold text-secondary" style="border-radius: 12px;">
                        <i class="bi bi-arrow-left me-2"></i> Kembali
                    </a>
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning shadow-sm px-4 fw-bold text-white" style="border-radius: 12px; background: linear-gradient(135deg, #f39c12, #e67e22); border:none;">
                        <i class="bi bi-pencil-square me-2"></i> Edit Produk
                    </a>
                </div>
            </div>

            <div class="row g-4">
                {{-- KIRI: Galeri Foto --}}
                <div class="col-lg-5">
                    <div class="card card-custom h-100">
                        <div class="card-body p-4">
                            <div class="main-image-container mb-3 shadow-sm text-center">
                                <img id="mainImage" src="{{ asset('storage/'.$product->primaryImage?->image_path) }}" 
                                     class="img-fluid" style="max-height: 400px; width: 100%; object-fit: contain;">
                            </div>
                            
                            <div class="row g-2">
                                @foreach($product->images as $image)
                                <div class="col-3">
                                    <img src="{{ asset('storage/'.$image->image_path) }}" 
                                         class="thumb-image w-100 shadow-sm" style="height: 70px;"
                                         onclick="changeImage(this.src)">
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KANAN: Detail Info --}}
                <div class="col-lg-7">
                    <div class="card card-custom h-100">
                        <div class="card-body p-4 p-md-5">
                            
                            <div class="mb-3 d-flex gap-2 align-items-center">
                                <span class="badge badge-custom bg-{{ $product->is_active ? 'success' : 'secondary' }} bg-opacity-10 text-{{ $product->is_active ? 'success' : 'secondary' }}">
                                    <i class="bi bi-circle-fill me-1 small"></i> {{ $product->is_active ? 'Status: Aktif' : 'Status: Nonaktif' }}
                                </span>
                                @if($product->is_featured)
                                <span class="badge badge-custom bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25">
                                    <i class="bi bi-star-fill me-1"></i> Produk Unggulan
                                </span>
                                @endif
                            </div>

                            <h1 class="product-title h2 mb-2">{{ $product->name }}</h1>
                            <p class="text-muted fs-5 mb-4">
                                <span class="badge bg-light text-dark fw-normal py-2 px-3 border">
                                    <i class="bi bi-folder2-open me-2"></i>Kategori: <strong>{{ $product->category->name }}</strong>
                                </span>
                            </p>

                            <div class="price-wrapper mb-4">
                                <div class="text-muted small fw-bold text-uppercase mb-1">Harga Saat Ini</div>
                                <h3 class="text-primary fw-bold mb-0">
                                    Rp {{ number_format($product->discount_price ?: $product->price, 0, ',', '.') }}
                                    @if($product->discount_price && $product->discount_price < $product->price)
                                        <span class="text-muted fs-6 text-decoration-line-through ms-2 fw-normal">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </span>
                                    @endif
                                </h3>
                            </div>

                            <h6 class="fw-bold text-dark mb-3">Deskripsi Produk</h6>
                            <div class="text-secondary mb-5 leading-relaxed" style="white-space: pre-line;">
                                {{ $product->description ?: 'Tidak ada deskripsi untuk produk ini.' }}
                            </div>

                            {{-- Statistik Bawah --}}
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="stat-card">
                                        <span class="stat-label">Persediaan</span>
                                        <span class="stat-value">{{ $product->stock }} <small class="text-muted fw-normal">Unit</small></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="stat-card">
                                        <span class="stat-label">Berat Satuan</span>
                                        <span class="stat-value">{{ number_format($product->weight, 0) }} <small class="text-muted fw-normal">Gram</small></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="stat-card">
                                        <span class="stat-label">Terdaftar Sejak</span>
                                        <span class="stat-value" style="font-size: 0.9rem;">{{ $product->created_at->format('d M Y') }}</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function changeImage(src) {
        document.getElementById('mainImage').src = src;
    }
</script>
@endsection