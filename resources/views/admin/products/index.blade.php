@extends('layouts.admin')

@section('title', 'Manajemen Produk')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #4834d4 0%, #686de0 100%);
    }

    .card-main {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    /* Filter Styling */
    .filter-card {
        background: #fff;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 25px;
        border: 1px solid #f1f5f9;
    }

    .form-control, .form-select {
        border-radius: 10px;
        padding: 0.6rem 1rem;
        border: 2px solid #f1f5f9;
        transition: 0.3s;
    }

    .form-control:focus, .form-select:focus {
        border-color: #4834d4;
        box-shadow: 0 0 0 3px rgba(72, 52, 212, 0.1);
    }

    /* Table Styling */
    .table thead th {
        background-color: #f8fafc;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
        font-weight: 700;
        color: #64748b;
        border-top: none;
        padding: 1.2rem;
    }

    .table tbody td {
        padding: 1.2rem;
        vertical-align: middle;
        color: #334155;
        font-size: 0.9rem;
    }

    .product-img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .btn-add {
        background: var(--primary-gradient);
        border: none;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        color: #fff;
        transition: 0.3s;
    }

    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(72, 52, 212, 0.3);
        color: #fff;
    }

    .action-btn {
        width: 35px;
        height: 35px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        transition: 0.2s;
        margin: 0 2px;
    }

    .badge-status {
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.75rem;
    }
</style>

<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 mb-1 fw-bold text-dark">Daftar Produk</h2>
            <p class="text-muted small mb-0">Kelola inventaris dan katalog produk Anda di sini.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-add">
            <i class="bi bi-plus-lg me-2"></i> Tambah Produk
        </a>
    </div>

    {{-- Filter Bar --}}
    <div class="filter-card shadow-sm">
        <form method="GET" class="row g-3">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0 text-muted">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0" 
                           placeholder="Cari nama produk..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-4">
                <select name="category" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-dark w-100 fw-bold" style="border-radius: 10px;">
                        Filter
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-light w-100 fw-bold" style="border-radius: 10px;">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- Table Card --}}
    <div class="card card-main">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ $product->primaryImage?->image_path ? asset('storage/'.$product->primaryImage->image_path) : asset('img/no-image.png') }}" 
                                     class="product-img me-3 border">
                                <div>
                                    <div class="fw-bold text-dark mb-0">{{ $product->name }}</div>
                                    <small class="text-muted">ID: #PRD-{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="text-secondary fw-semibold">
                                <i class="bi bi-tag-fill me-1 small"></i> {{ $product->category->name }}
                            </span>
                        </td>
                        <td>
                            <div class="fw-bold text-dark">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                            @if($product->discount_price)
                                <small class="text-danger text-decoration-line-through">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</small>
                            @endif
                        </td>
                        <td>
                            @if($product->stock <= 5)
                                <span class="text-danger fw-bold"><i class="bi bi-exclamation-triangle-fill me-1"></i>{{ $product->stock }}</span>
                            @else
                                <span class="text-dark fw-bold">{{ $product->stock }}</span>
                            @endif
                        </td>
                        <td>
                            @if($product->is_active)
                                <span class="badge badge-status bg-success bg-opacity-10 text-success border border-success border-opacity-25">Aktif</span>
                            @else
                                <span class="badge badge-status bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('admin.products.show', $product) }}" class="action-btn btn btn-outline-info" title="Lihat Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.products.edit', $product) }}" class="action-btn btn btn-outline-warning" title="Edit Produk">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="action-btn btn btn-outline-danger" title="Hapus Produk">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <img src="https://illustrations.popsy.co/flat/searching-for-answers.svg" style="width: 150px;" class="mb-3 opacity-50">
                            <p class="text-muted fw-semibold">Oops! Tidak ada produk yang ditemukan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-between align-items-center mt-4 px-2">
        <p class="text-muted small mb-0">
            Menampilkan {{ $products->firstItem() }} sampai {{ $products->lastItem() }} dari {{ $products->total() }} produk
        </p>
        <div>
            {{ $products->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection