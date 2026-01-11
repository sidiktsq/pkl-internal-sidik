{{-- ================================================
     FILE: resources/views/partials/footer.blade.php
     FUNGSI: Footer website (Elegant Midnight Theme)
     ================================================ --}}

<style>
    .custom-footer {
        background: #0d1626 !important; /* Hitam Kebiruan */
        border-top: 1px solid #1a2f4d;
        color: #d1e3ff;
    }

    .footer-brand {
        font-weight: 700;
        letter-spacing: 1px;
        color: #00a8ff !important;
    }

    .footer-title {
        color: #ffffff;
        font-weight: 600;
        margin-bottom: 1.5rem;
        position: relative;
    }

    .footer-link {
        color: #a3b9cc;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-block;
    }

    .footer-link:hover {
        color: #00a8ff;
        transform: translateX(5px);
    }

    .social-icon {
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid #1a2f4d;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        color: #00a8ff;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .social-icon:hover {
        background: #00a8ff;
        color: #ffffff;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 168, 255, 0.3);
    }

    .contact-info i {
        color: #00a8ff;
        font-size: 1.1rem;
    }

    .footer-bottom-border {
        border-top: 1px solid rgba(26, 47, 77, 0.5);
    }
</style>

<footer class="custom-footer pt-5 pb-4 mt-5">
    <div class="container">
        <div class="row g-4">
            {{-- Brand & Description --}}
            <div class="col-lg-4 col-md-12">
                <h5 class="footer-brand mb-3">
                    <i class="bi bi-bag-heart-fill me-2"></i>FASHION SMK
                </h5>
                <p class="text-secondary pe-lg-5" style="line-height: 1.8;">
                    Destinasi fashion online terpercaya yang menghadirkan koleksi eksklusif berkualitas premium. 
                    Kami berkomitmen memberikan pengalaman belanja yang aman, modern, dan berkelas.
                </p>
                <div class="d-flex gap-2 mt-4">
                    <a href="#" class="social-icon"><i class="bi bi-facebook"></i></a>
                    <a href="https://www.instagram.com/inimsss/" class="social-icon" target="_blank"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="bi bi-twitter-x"></i></a>
                    <a href="https://www.youtube.com/@IniMsss-k9b" class="social-icon"><i class="bi bi-youtube"></i></a>
                </div>
            </div>

            {{-- Quick Links --}}
            <div class="col-lg-2 col-md-4 col-6">
                <h6 class="footer-title">Navigasi</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="{{ route('catalog.index') }}" class="footer-link">Katalog Produk</a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="footer-link">Tentang Kami</a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="footer-link">Kontak</a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="footer-link">Promo Spesial</a>
                    </li>
                </ul>
            </div>

            {{-- Help --}}
            <div class="col-lg-2 col-md-4 col-6">
                <h6 class="footer-title">Bantuan</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="#" class="footer-link">FAQ</a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="footer-link">Cara Belanja</a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="footer-link">Kebijakan Privasi</a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="footer-link">Syarat & Ketentuan</a>
                    </li>
                </ul>
            </div>

            {{-- Contact --}}
            <div class="col-lg-4 col-md-4 contact-info">
                <h6 class="footer-title">Hubungi Kami</h6>
                <ul class="list-unstyled">
                    <li class="mb-3 d-flex align-items-start">
                        <i class="bi bi-geo-alt me-3"></i>
                        <span class="text-secondary small">Jl. Contoh No. 123, Pusat Fashion Digital, Bandung</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="bi bi-telephone me-3"></i>
                        <span class="text-secondary small">(022) 123-4567</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="bi bi-envelope me-3"></i>
                        <span class="text-secondary small">info@FashionSmk.com</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom-border mt-5 pt-4">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="text-secondary mb-0 small" style="opacity: 0.8;">
                        &copy; {{ date('Y') }} <span class="text-white fw-bold">Fashion Smk</span>. All rights reserved.
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                    {{-- Ganti asset dengan filter grayscale/light agar cocok dengan tema gelap --}}
                    <div class="d-flex justify-content-center justify-content-md-end gap-3 grayscale-payment">
                         <span class="small text-secondary me-2">Metode Pembayaran Aman:</span>
                         <i class="bi bi-credit-card-2-front text-secondary fs-5"></i>
                         <i class="bi bi-bank text-secondary fs-5"></i>
                         <i class="bi bi-wallet2 text-secondary fs-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>