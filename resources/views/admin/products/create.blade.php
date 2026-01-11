@extends('layouts.admin')

@section('title', 'Tambah Produk Baru')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #4834d4 0%, #686de0 100%);
    }

    .card-custom {
        border: none;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.05);
    }

    .form-label {
        font-weight: 600;
        color: #475569;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.7rem;
    }

    .form-control, .form-select {
        border-radius: 12px;
        padding: 0.75rem 1rem;
        border: 2px solid #f1f5f9;
        background-color: #f8fafc;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        background-color: #fff;
        border-color: #4834d4;
        box-shadow: 0 0 0 4px rgba(72, 52, 212, 0.1);
    }

    .input-group-text {
        background-color: #f1f5f9;
        border: 2px solid #f1f5f9;
        border-radius: 12px 0 0 12px;
        color: #64748b;
    }

    .btn-save {
        background: var(--primary-gradient);
        border: none;
        padding: 12px;
        border-radius: 12px;
        font-weight: 700;
        transition: 0.3s;
    }

    .btn-save:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(72, 52, 212, 0.2);
    }

    .upload-section {
        border: 2px dashed #cbd5e1;
        border-radius: 15px;
        padding: 2rem;
        text-align: center;
        background-color: #f8fafc;
        transition: 0.3s;
        cursor: pointer;
    }

    .upload-section:hover {
        border-color: #4834d4;
        background-color: #f1f0ff;
    }

    .section-title {
        position: relative;
        padding-bottom: 10px;
        margin-bottom: 20px;
        font-weight: 700;
        color: #1e293b;
    }

    .section-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 50px;
        height: 4px;
        background: var(--primary-gradient);
        border-radius: 2px;
    }
</style>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            
            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="h3 mb-1 fw-bold text-dark">Tambah Produk Baru</h2>
                    <p class="text-muted small mb-0">Lengkapi detail informasi produk Anda di bawah ini.</p>
                </div>
                <a href="{{ route('admin.products.index') }}" class="btn btn-light border-0 shadow-sm px-4 fw-bold text-secondary" style="border-radius: 10px;">
                    <i class="bi bi-arrow-left me-2"></i> Kembali
                </a>
            </div>

            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="card card-custom">
                    <div class="card-body p-4 p-md-5">
                        
                        {{-- Section 1: Informasi Dasar --}}
                        <h5 class="section-title">Informasi Dasar</h5>
                        <div class="row mb-4">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Nama Lengkap Produk</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                       placeholder="Contoh: Kaos Polos Cotton Combed 30s" value="{{ old('name') }}">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Kategori</label>
                                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                    <option value="">Pilih Kategori Produk...</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- Section 2: Inventaris & Logistik --}}
                        <h5 class="section-title">Harga & Stok</h5>
                        <div class="row mb-4">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Harga Satuan</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="price" class="form-control" placeholder="0" value="{{ old('price') }}">
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Jumlah Stok</label>
                                <div class="input-group">
                                    <input type="number" name="stock" class="form-control" placeholder="0" value="{{ old('stock') }}">
                                    <span class="input-group-text text-small">Unit</span>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Berat Produk</label>
                                <div class="input-group">
                                    <input type="number" name="weight" class="form-control @error('weight') is-invalid @enderror" 
                                           placeholder="0" value="{{ old('weight') }}" min="1" required>
                                    <span class="input-group-text">Gram</span>
                                </div>
                                @error('weight') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- Section 3: Media --}}
                        <h5 class="section-title">Media Produk</h5>
                        <div class="mb-4">
                            <label class="form-label">Foto Produk (Bisa lebih dari satu)</label>
                            <div class="upload-section" onclick="document.getElementById('fileInput').click();">
                                <i class="bi bi-cloud-arrow-up text-primary mb-2" style="font-size: 3rem;"></i>
                                <h6 class="fw-bold mb-1 text-dark">Klik untuk unggah gambar</h6>
                                <p class="text-muted small">Mendukung format JPG, PNG, atau WEBP.</p>
                                <input type="file" id="fileInput" name="images[]" multiple class="d-none" onchange="previewImages(event)">
                            </div>
                            <div id="imagePreviewContainer" class="d-flex flex-wrap gap-2 mt-3"></div>
                        </div>

                        <hr class="my-4" style="opacity: 0.1;">

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-save w-100 shadow-sm">
                                    <i class="bi bi-check2-circle me-2"></i> Simpan Produk Sekarang
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Fungsi simple untuk melihat preview gambar yang akan diupload
    function previewImages(event) {
        const container = document.getElementById('imagePreviewContainer');
        container.innerHTML = '';
        const files = event.target.files;

        for (let i = 0; i < files.length; i++) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = '100px';
                img.style.height = '100px';
                img.style.objectFit = 'cover';
                img.classList.add('rounded-3', 'border', 'shadow-sm');
                container.appendChild(img);
            }
            reader.readAsDataURL(files[i]);
        }
    }
</script>
@endsection