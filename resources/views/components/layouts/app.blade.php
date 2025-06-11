<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    
    {{-- FontAwesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- Livewire Styles --}}
    @livewireStyles

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>{{ $title ?? 'Page Title' }}</title>

    {{-- Custom Style --}}
    <style>
        .navbar-custom {
            background-color: #B11C22;
        }
        .navbar-custom .navbar-brand img {
            max-height: 50px;
        }
        .navbar-custom .nav-link {
            color: white;
            margin: 0 10px;
        }
        .navbar-custom .nav-link:hover,
        .navbar-custom .nav-link:focus {
            color: #f0f0f0;
        }
        .navbar-custom .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        .navbar-custom .navbar-toggler {
            border-color: rgba(255,255,255,0.5);
        }

        body {
            background-color: #f8f9fa;
        }

        .promo-section {
            background-color: #ffffff;
            padding: 30px;
            margin-bottom: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }

        .promo-section .promo-title {
            font-weight: bold;
            font-size: 1.8rem;
            margin-bottom: 15px;
        }

        .bg-danger {
            background-color: #B11C22 !important;
        }

        .promo-section .promo-title .highlight {
            color: #B11C22;
        }

        .promo-section .promo-description {
            font-size: 1rem;
            color: #6c757d;
            margin-bottom: 20px;
        }

        .promo-section .btn-promo {
            background-color: rgb(53, 168, 79);
            border-color: #28a745;
            color: white;
            font-weight: bold;
            padding: 10px 25px;
            border-radius: 20px;
            box-shadow: 0px 6px 1px rgba(0, 0, 0, 0.5);
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

        @media (max-width: 767.98px) {
            .promo-section .row > div {
                text-align: center;
            }
            .promo-section .promo-image {
                margin-bottom: 20px;
            }
            .promo-section .promo-title {
                font-size: 1.5rem;
            }
        }

        .footer-custom {
            background-color: #343a40;
            color: #f8f9fa;
        }

        .footer-custom h4 {
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .footer-custom p,
        .footer-custom li {
            color: #adb5bd;
        }

        .footer-custom strong {
            color: #f8f9fa;
        }

        .footer-custom .open-hours-list li {
            display: flex;
            justify-content: space-between;
            padding: 2px 0;
        }

        .footer-custom .contact-item {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }

        .footer-custom .contact-item i {
            font-size: 1.2rem;
        }

        .footer-custom .left-gap {
            padding-left: 20px;
        }

        .footer-custom .right-gap {
            padding-right: 20px;
        }

        .btn-circle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            font-weight: bold;
            font-size: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body class="{{ (isset($title) && $title === 'Login') ? 'login-page' : '' }}">

    {{-- Livewire Layout --}}
    <div>
        @livewire('layout.header')

        {{ $slot }}

        @livewire('layout.footer')
    </div>

    {{-- Bootstrap Bundle --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>

    {{-- Livewire Scripts --}}
    @livewireScripts
</body>
</html>
