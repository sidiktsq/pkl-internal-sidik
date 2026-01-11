@extends('layouts.app')

@section('content')
<style>
    /* Custom CSS Tema Hitam Kebiruan Elegan */
    body {
        background-color: #050a15; 
        background-image: radial-gradient(circle at top right, #0a1931, #050a15);
        min-height: 100vh;
        color: #e0e6ed;
    }
    
    .card-register {
        background-color: #0d1626; 
        border: 1px solid #1a2f4d;
        border-radius: 15px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.7);
        overflow: hidden;
    }

    .card-header-gradient {
        background: linear-gradient(135deg, #0a1931 0%, #007bff 100%);
        border-bottom: 1px solid #1a2f4d;
        padding: 1.5rem !important;
    }

    .form-control-dark {
        background-color: #060b13;
        border: 1px solid #1a2f4d;
        color: #d1e3ff;
        border-radius: 8px;
        padding: 0.75rem 1rem;
    }

    .form-control-dark:focus {
        background-color: #08111d;
        border-color: #00a8ff;
        color: white;
        box-shadow: 0 0 12px rgba(0, 168, 255, 0.3);
    }

    .btn-register {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        border: none;
        color: white;
        padding: 0.8rem;
        border-radius: 8px;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }

    .btn-register:hover {
        background: linear-gradient(135deg, #0095ff 0%, #007bff 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4);
        color: white;
    }

    .text-blue-light {
        color: #82b1ff;
    }

    .form-label {
        font-weight: 500;
        color: #a5b4fc;
    }

    /* Memperbaiki tampilan error */
    .invalid-feedback {
        color: #ff6b6b;
        font-size: 0.85rem;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card card-register border-0">
                
                {{-- Header --}}
                <div class="card-header card-header-gradient text-center">
                    <h3 class="mb-0 fw-bold text-white">✨ Buat Akun Baru</h3>
                    <p class="text-white-50 small mb-0 mt-2">Silahkan lengkapi data diri Anda</p>
                </div>

                <div class="card-body p-4 p-md-5">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        {{-- Nama Lengkap --}}
                        <div class="mb-4">
                            <label for="name" class="form-label small">NAMA LENGKAP</label>
                            <input id="name" type="text" 
                                class="form-control form-control-dark @error('name') is-invalid @enderror" 
                                name="name" value="{{ old('name') }}" required 
                                placeholder="Masukkan nama lengkap" autocomplete="name" autofocus>
                            
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-4">
                            <label for="email" class="form-label small">ALAMAT EMAIL</label>
                            <input id="email" type="email" 
                                class="form-control form-control-dark @error('email') is-invalid @enderror" 
                                name="email" value="{{ old('email') }}" required 
                                placeholder="nama@perusahaan.com" autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="password" class="form-label small">PASSWORD</label>
                                <input id="password" type="password" 
                                    class="form-control form-control-dark @error('password') is-invalid @enderror" 
                                    name="password" required 
                                    placeholder="••••••••" autocomplete="new-password">
                                
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Confirm Password --}}
                            <div class="col-md-6 mt-4 mt-md-0">
                                <label for="password-confirm" class="form-label small">KONFIRMASI</label>
                                <input id="password-confirm" type="password" 
                                    class="form-control form-control-dark" 
                                    name="password_confirmation" required 
                                    placeholder="••••••••" autocomplete="new-password">
                            </div>
                        </div>

                        {{-- Tombol Register --}}
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-register shadow-sm">
                                DAFTAR SEKARANG
                            </button>
                        </div>

                        {{-- Link Login --}}
                        <div class="text-center mt-4">
                            <p class="small text-blue-light mb-0">
                                Sudah punya akun? 
                                <a href="{{ route('login') }}" class="text-blue-light fw-bold text-decoration-none">
                                    Masuk di sini
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Footer Tambahan (Opsional) --}}
            <div class="text-center mt-4 text small">
                &copy; {{ date('Y') }} - {{ config('app.name', 'Laravel') }}. All rights reserved.
            </div>
        </div>
    </div>
</div>
@endsection