<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js" integrity="sha384-RuyvpeZCxMJCqVUGFI0Do1mQrods/hhxYlcVfGPOfQtPJh0JCw12tUAZ/Mv10S7D" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <title>{{ $title ?? 'Page Title' }}</title>
          <style>
         /* Anda bisa menyesuaikan warna merah ini agar lebih mirip dengan gambar */
        .navbar-custom {
            background-color: #B11C22; /* Warna merah dari screenshot (perkiraan) */
        }
        .navbar-custom .navbar-brand img {
            max-height: 50px; /* Sesuaikan tinggi logo */
        }
        .navbar-custom .nav-link {
            color: white;
            margin-left: 10px;
            margin-right: 10px;
        }
        .navbar-custom .nav-link:hover,
        .navbar-custom .nav-link:focus {
            color: #f0f0f0; /* Warna saat hover */
        }
        .navbar-custom .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        .navbar-custom .navbar-toggler {
            border-color: rgba(255,255,255,0.5);
        }
                body {
            background-color: #f8f9fa; /* Warna latar belakang halaman sedikit abu-abu */
        }

        .promo-section {
            background-color: #ffffff; /* Latar belakang setiap kartu promosi putih */
            padding: 30px;
            margin-bottom: 30px; /* Jarak antar komponen */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }

        .promo-section .promo-title {
            font-weight: bold;
            font-size: 1.8rem; /* Ukuran font judul */
            margin-bottom: 15px;
        }

        .promo-section .promo-title .highlight {
            color: #dc3545; /* Warna merah untuk teks yang di-highlight */
        }

        .promo-section .promo-description {
            font-size: 1rem;
            color: #6c757d; /* Warna teks deskripsi sedikit abu-abu */
            margin-bottom: 20px;
        }

        .promo-section .btn-promo {
            background-color: #28a745; /* Warna hijau untuk tombol */
            border-color: #28a745;
            color: white;
            font-weight: bold;
            padding: 10px 25px;
            border-radius: 20px; /* Tombol lebih rounded */
        }

        .promo-section .btn-promo:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .promo-section .promo-image img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        /* Responsif: tumpuk kolom di layar kecil */
        @media (max-width: 767.98px) {
            .promo-section .row > div {
                text-align: center; /* Pusatkan teks di mobile */
            }
            .promo-section .promo-image {
                margin-bottom: 20px; /* Beri jarak antara gambar dan teks di mobile */
            }
            .promo-section .promo-title {
                font-size: 1.5rem;
            }
        }
                .footer-custom {
            background-color: #343a40; /* Warna gelap seperti di gambar, Bootstrap bg-dark */
            color: #f8f9fa; /* Warna teks terang, Bootstrap text-light */
        }
        .footer-custom h4 {
            margin-bottom: 1rem;
            font-weight: bold;
        }
        .footer-custom p, .footer-custom li {
            color: #adb5bd; /* Warna teks sedikit lebih redup untuk detail */
        }
        .footer-custom strong, .footer-custom h4 {
             color: #f8f9fa; /* Pastikan heading dan strong tetap terang */
        }
        .open-hours-list li {
            display: flex;
            justify-content: space-between;
            padding-bottom: 0.25rem;
        }
        .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
        }
        .contact-item i {
            font-size: 1.2rem;
            margin-right: 0.75rem;
        }
        
            </style>
    </head>
    <body>
        <div>
            @livewire('layout.header')
                {{ $slot }}
            @livewire('layout.footer')
        </div>
    </body>
</html>
