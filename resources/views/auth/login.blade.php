@extends('layouts.app')

@section('content')
<style>
    /* Custom CSS untuk Tema Hitam Kebiruan (Dark Blue/Deep Ocean Theme) */
    body {
        /* Background hitam dengan rona biru laut dalam */
        background-color: #050a15; 
        background-image: radial-gradient(circle at top right, #0a1931, #050a15);
        min-height: 100vh;
    }
    
    .card-dark-blue {
        /* Card hitam kebiruan */
        background-color: #0d1626; 
        border: 1px solid #1a2f4d; /* Border biru gelap */
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.6), 0 0 20px rgba(0, 123, 255, 0.05);
    }

    /* Header dengan gradasi biru tua ke biru terang (Cyan/Azure) */
    .card-header-gradient {
        background: linear-gradient(135deg, #0a1931 0%, #007bff 100%);
        border-bottom: 1px solid #1a2f4d;
    }

    /* Input dengan warna hitam kebiruan pekat */
    .form-control-dark {
        background-color: #060b13;
        border: 1px solid #1a2f4d;
        color: #d1e3ff;
    }

    .form-control-dark:focus {
        background-color: #08111d;
        border-color: #00a8ff;
        color: white;
        box-shadow: 0 0 8px rgba(0, 168, 255, 0.4);
    }

    /* Tombol Utama Biru */
    .btn-blue {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        border: none;
        color: white;
        transition: all 0.3s ease;
    }

    .btn-blue:hover {
        background: linear-gradient(135deg, #0095ff 0%, #007bff 100%);
        transform: translateY(-1px);
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4);
        color: white;
    }

    /* Tombol Outline untuk Google */
    .btn-outline-blue {
        color: #82b1ff;
        border: 1px solid #007bff;
        background-color: transparent;
    }

    .btn-outline-blue:hover {
        background-color: rgba(0, 123, 255, 0.1);
        border-color: #00a8ff;
        color: white;
    }

    .text-blue-light {
        color: #82b1ff;
    }

    .invalid-feedback {
        color: #ff6b6b; /* Merah terang agar tetap kontras di background biru */
    }

    hr {
        border-top: 1px solid #1a2f4d;
        opacity: 0.6;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="card shadow-lg card-dark-blue text-white border-0">
                
                <div class="card-header card-header-gradient py-4 text-center">
                    <h4 class="mb-0 fw-bold tracking-tight">🔐 Masuk ke Akun</h4>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label small text-blue-light fw-bold">ALAMAT EMAIL</label>
                            <input id="email" type="email" 
                                class="form-control form-control-dark @error('email') is-invalid @enderror" 
                                name="email" value="{{ old('email') }}" required autofocus
                                placeholder="nama@email.com">
                            
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label small text-blue-light fw-bold">PASSWORD</label>
                            <input id="password" type="password" 
                                class="form-control form-control-dark @error('password') is-invalid @enderror" 
                                name="password" required 
                                placeholder="••••••••">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-4 d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" 
                                    {{ old('remember') ? 'checked' : '' }} style="cursor:pointer; background-color: #060b13; border-color: #1a2f4d;">
                                <label class="form-check-label small text-blue-light" for="remember" style="cursor:pointer;">
                                    Ingat Saya
                                </label>
                            </div>
                            @if (Route::has('password.request'))
                                <a class="text-blue-light text-decoration-none small fw-bold" href="{{ route('password.request') }}">
                                    Lupa Password?
                                </a>
                            @endif
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-blue btn-lg fw-bold shadow-sm">
                                LOGIN
                            </button>
                        </div>

                        <div class="position-relative my-4">
                            <hr>
                            <span class="position-absolute top-50 start-50 translate-middle px-3 small text-blue-light" style="background-color: #0d1626;">ATAU</span>
                        </div>

                        <div class="d-grid gap-2">
                            <a href="{{ route('auth.google') }}" class="btn btn-outline-blue d-flex align-items-center justify-content-center py-2">
                                <svg class="me-2" width="18" height="18" viewBox="0 0 24 24">
                                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                </svg>
                                Login dengan Google
                            </a>
                        </div>

                        <p class="mt-4 text-center mb-0 small text-blue-light">
                            Belum punya akun? 
                            <a href="{{ route('register') }}" class="text-blue-light fw-bold text-decoration-none">Daftar Sekarang</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection