{{-- ================================================
     FILE: resources/views/profile/edit.blade.php
     FUNGSI: Halaman Edit Profil (Elegant Midnight)
     ================================================ --}}

@extends('layouts.app')

@section('title', 'Pengaturan Profil')

@section('content')
<style>
    body {
        background-color: #060b13;
        color: #ffffff; /* Mengubah default teks body ke putih */
    }

    /* Heading Style */
    .profile-title {
        color: #ffffff;
        font-weight: 700;
        letter-spacing: 1px;
        position: relative;
        padding-bottom: 15px;
        display: inline-block;
    }

    .profile-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50%;
        height: 4px;
        background: linear-gradient(90deg, #00a8ff, transparent);
        border-radius: 2px;
    }

    /* Glassmorphism Card Custom */
    .card-midnight {
        background: rgba(26, 47, 77, 0.2) !important;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(26, 47, 77, 0.4) !important;
        border-radius: 15px;
        margin-bottom: 1.5rem;
    }

    .card-midnight .card-header {
        background: rgba(13, 22, 38, 0.5) !important;
        border-bottom: 1px solid rgba(26, 47, 77, 0.4) !important;
        color: #ffffff !important; /* Header card menjadi putih */
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 15px 20px;
        border-radius: 15px 15px 0 0 !important;
    }

    .card-midnight .card-body {
        padding: 25px;
        color: #ffffff !important; /* Memastikan isi card putih */
    }

    /* Styling Label Form agar tetap putih */
    .card-midnight label {
        color: #ffffff !important;
    }

    /* --- ELEGANT CHOOSE FILE STYLING --- */
    input[type="file"] {
        color: #ffffff;
        background: rgba(13, 22, 38, 0.5);
        border: 1px solid #1a2f4d;
        border-radius: 8px;
        padding: 6px;
        width: 100%;
    }

    input[type="file"]::file-selector-button {
        margin-right: 15px;
        border: none;
        background: #00a8ff;
        padding: 8px 16px;
        border-radius: 6px;
        color: #ffffff;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 600;
        font-size: 0.85rem;
    }

    /* Custom Teks Instruksi */
    .instruction-text {
        color: #ffffff !important; /* Teks instruksi putih */
        font-size: 0.9rem;
        margin-bottom: 1rem;
        display: block;
    }

    .instruction-highlight {
        background: rgba(255, 255, 255, 0.05); /* Latar belakang lebih netral */
        border-left: 3px solid #00a8ff;
        padding: 10px 15px;
        border-radius: 4px;
        margin-bottom: 20px;
    }

    /* Form Elements Override */
    .card-midnight input, 
    .card-midnight textarea, 
    .card-midnight select {
        background-color: rgba(13, 22, 38, 0.8) !important;
        border: 1px solid #1a2f4d !important;
        color: #ffffff !important;
        border-radius: 8px;
    }

    /* Memastikan placeholder terlihat sedikit redup tapi tetap di skema putih */
    .card-midnight input::placeholder {
        color: rgba(255, 255, 255, 0.5) !important;
    }

    /* Button Styling */
    .btn-save-midnight {
        background: #00a8ff;
        border: none;
        color: white !important;
        padding: 10px 25px;
        font-weight: 600;
        border-radius: 8px;
        transition: 0.3s;
        box-shadow: 0 4px 15px rgba(0, 168, 255, 0.3);
    }

    /* Info Alert Custom */
    .alert-midnight {
        background: rgba(0, 168, 255, 0.2);
        border: 1px solid #00a8ff;
        color: #ffffff;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            
            <div class="mb-5 text-center text-lg-start">
                <h2 class="profile-title mb-2">Pengaturan Profil</h2>
                <p class="text-white">Kelola informasi akun dan preferensi keamanan Anda.</p>
            </div>

            @if (session('success'))
                <div class="alert alert-midnight alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- 1. Avatar Information --}}
            <div class="card card-midnight shadow-sm">
                <div class="card-header fw-bold">
                    <i class="bi bi-person-circle me-2"></i> Foto Profil
                </div>
                <div class="card-body">
                    <div class="instruction-highlight">
                        <span class="instruction-text mb-0">
                            <i class="bi bi-cloud-arrow-up me-2 text-info"></i>
                            Upload foto profil kamu. Format yang didukung: <strong>JPG, PNG, WebP</strong>. Maksimal <strong>2MB</strong>.
                        </span>
                    </div>
                    @include('profile.partials.update-avatar-form')
                </div>
            </div>

            {{-- 2. Profile Information --}}
            <div class="card card-midnight shadow-sm">
                <div class="card-header fw-bold">
                    <i class="bi bi-card-list me-2"></i> Informasi Dasar
                </div>
                <div class="card-body">
                    <span class="instruction-text">
                        <i class="bi bi-info-circle me-2 text-info"></i>
                        Perbarui informasi profil dan alamat email kamu.
                    </span>
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- 3. Update Password --}}
            <div class="card card-midnight shadow-sm">
                <div class="card-header fw-bold">
                    <i class="bi bi-shield-lock me-2"></i> Keamanan Akun
                </div>
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- 4. Connected Accounts --}}
            <div class="card card-midnight shadow-sm">
                <div class="card-header fw-bold">
                    <i class="bi bi-link-45deg me-2"></i> Akun Terhubung
                </div>
                <div class="card-body">
                    @include('profile.partials.connected-accounts')
                </div>
            </div>

            {{-- 5. Delete Account --}}
            <div class="card card-midnight shadow-sm border-danger mt-5">
                <div class="card-header fw-bold text-white bg-danger bg-opacity-25">
                    <i class="bi bi-exclamation-triangle me-2"></i> Zona Berbahaya
                </div>
                <div class="card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    document.querySelectorAll('button[type="submit"]').forEach(btn => {
        if(!btn.classList.contains('btn-danger')) {
            btn.classList.add('btn-save-midnight');
        }
    });
</script>
@endsection