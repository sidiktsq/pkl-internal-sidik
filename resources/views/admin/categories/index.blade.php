@extends('layouts.admin')

@section('title', 'Manajemen Kategori')

@section('content')
<style>
    /* 1. Perbaikan pada Container Modal agar tidak transparan/bertabrakan */
    .modal-backdrop {
        z-index: 1040 !important;
    }
    .modal {
        z-index: 1050 !important;
    }
    
    /* 2. Styling Elegan */
    :root {
        --primary-gradient: linear-gradient(135deg, #4834d4 0%, #686de0 100%);
    }

    .card-custom {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        background: #fff;
    }

    .table thead th {
        background-color: #f8fafc !important;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
        font-weight: 700;
        color: #64748b;
        padding: 15px 20px;
        border-top: none;
    }

    /* 3. Modal UI Fix */
    .modal-content {
        border: none;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        background-color: #ffffff; /* Memastikan background solid */
    }

    .modal-header {
        border-bottom: 1px solid #f1f5f9;
        padding: 1.25rem 1.5rem;
    }

    .modal-body {
        padding: 1.5rem;
    }

    /* 4. Form Styling */
    .form-label {
        font-weight: 600;
        color: #475569;
        font-size: 0.85rem;
        margin-bottom: 0.5rem;
        display: block;
    }

    .form-control {
        border-radius: 10px;
        padding: 0.6rem 1rem;
        border: 2px solid #f1f5f9;
        background-color: #f8fafc;
    }

    .form-control:focus {
        background-color: #fff;
        border-color: #4834d4;
        box-shadow: 0 0 0 3px rgba(72, 52, 212, 0.1);
    }

    .image-box-preview {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 12px;
        border: 3px solid #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .bg-light-custom {
        background-color: #f8fafc;
        border-radius: 12px;
        padding: 15px;
    }
</style>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-12">
            
            {{-- Flash Message --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card card-custom">
                <div class="card-header bg-white py-3 px-4 d-flex justify-content-between align-items-center border-0">
                    <div>
                        <h4 class="mb-0 fw-bold text-dark">Daftar Kategori</h4>
                        <p class="text-muted small mb-0">Total {{ $categories->count() }} kategori ditemukan</p>
                    </div>
                    <button class="btn btn-primary px-4 shadow-sm" style="border-radius: 10px; background: var(--primary-gradient); border:none;" data-bs-toggle="modal" data-bs-target="#createModal">
                        <i class="bi bi-plus-lg me-2"></i> Tambah Baru
                    </button>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">Informasi Kategori</th>
                                    <th class="text-center">Produk</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center py-2">
                                                @if($category->image)
                                                    <img src="{{ Storage::url($category->image) }}" class="rounded-3 me-3" width="50" height="50" style="object-fit: cover;">
                                                @else
                                                    <div class="bg-light rounded-3 d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                                        <i class="bi bi-image text-muted"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="fw-bold text-dark mb-0">{{ $category->name }}</div>
                                                    <small class="text-muted">{{ $category->slug }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary px-3">
                                                {{ $category->products_count }} Produk
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if($category->is_active)
                                                <span class="badge bg-success bg-opacity-10 text-success px-3">
                                                    <i class="bi bi-circle-fill me-1" style="font-size: 6px;"></i> Aktif
                                                </span>
                                            @else
                                                <span class="badge bg-secondary bg-opacity-10 text-secondary px-3">Non-Aktif</span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-4">
                                            <button class="btn btn-sm btn-outline-warning border-0 me-1" data-bs-toggle="modal" data-bs-target="#editModal{{ $category->id }}">
                                                <i class="bi bi-pencil-square fs-5"></i>
                                            </button>
                                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kategori ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger border-0">
                                                    <i class="bi bi-trash fs-5"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    {{-- MODAL EDIT --}}
                                    <div class="modal fade" id="editModal{{ $category->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fw-bold">Edit Kategori</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Nama Kategori</label>
                                                            <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Gambar Kategori</label>
                                                            <div class="d-flex align-items-center bg-light-custom border border-dashed mb-2">
                                                                @if($category->image)
                                                                    <img src="{{ Storage::url($category->image) }}" class="image-box-preview me-3">
                                                                @endif
                                                                <input type="file" name="image" class="form-control form-control-sm">
                                                            </div>
                                                        </div>
                                                        <div class="bg-light-custom d-flex justify-content-between align-items-center">
                                                            <span class="fw-bold text-dark">Status Aktif</span>
                                                            <div class="form-check form-switch mb-0">
                                                                <input class="form-check-input fs-5" type="checkbox" name="is_active" value="1" {{ $category->is_active ? 'checked' : '' }}>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer border-0">
                                                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary px-4" style="border-radius:10px;">Simpan Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">Belum ada data.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL CREATE --}}
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Kategori Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: Kaos Polos" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gambar Cover</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                    <div class="bg-light-custom d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-dark">Langsung Aktifkan</span>
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input fs-5" type="checkbox" name="is_active" value="1" checked>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4" style="border-radius:10px;">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection