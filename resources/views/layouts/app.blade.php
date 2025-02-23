<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Inventory Micro Controller</title>

    <!-- Fonts & Icons -->
    <link rel="shortcut icon" href="{{ asset('images/mc.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Calibri:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://uicdn.toast.com/tui-calendar/latest/tui-calendar.css" />
    <link rel="stylesheet" href="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.css" />
    <link rel="stylesheet" href="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200');
        @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Titillium+Web:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700&display=swap');

        :root {
            --primary-color: #547c90;
            --sec-color: #265166;
            --acc-color: #f6fafd;
            --bg-color: #d0f1e6;
            --pungki: #f1dcd0;
            --meramera: #ca4c44;
            --birusepuh: #1e3745;
            --birupemula: #bacfda;
            --abusepuh: #414a4e;
        }

        * {
            font-family: 'Titillium Web', serif;
        }

        *::selection {
            background-color: var(--meramera);
            color: var(--acc-color);
        }

        .table-responsive {
            width: 100%;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            background: var(--bg-color);
            border-radius: 10px;
            overflow: hidden;
        }

        .table thead {
            background: var(--primary-color);
            color: white;
            font-weight: bold;
        }

        .table th,
        .table td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 2px solid var(--birupemula);
        }

        .table th {
            font-size: 14px;
            letter-spacing: 1px;
        }

        .table tbody tr {
            transition: background 0.3s ease-in-out;
        }

        .table tbody tr:nth-child(even) {
            background: var(--pungki);
        }

        .table tbody tr:hover {
            background: var(--sec-color);
            color: white;
        }

        .table .btn {
            padding: 6px 12px;
            font-size: 13px;
            border-radius: 6px;
            transition: 0.3s;
        }

        .btn-edit {
            background: var(--birusepuh);
            color: white;
            border: none;
        }

        .btn-delete {
            background: var(--meramera);
            color: white;
            border: none;
        }

        .btn-edit:hover {
            background: var(--abusepuh);
        }

        .btn-delete:hover {
            background: darkred;
        }

        @media (max-width: 768px) {
            .icon-micro h1 {
                display: none !important;
            }

            .icon-micro hr {
                display: none !important;
            }

            .icon-micro img {
                width: 85% !important;
            }

            .table th,
            .table td {
                font-size: 12px;
                padding: 8px 12px;
                white-space: nowrap;
            }

            .table-responsive {
                border-radius: 10px;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .menu {
                max-width: 76px;
            }

            .menu-content {
                margin-left: -24px !important;
            }

            .menu-content li a span.txt-sb {
                display: none;
            }

            .menu-content li a span.material-symbols-outlined {
                margin-right: 0;
            }

            .menu-content li {
                padding-left: 0;
                text-align: center;
            }

            .main-content {
                margin-left: 85px !important;
                width: calc(100% - 85px) !important;
            }

            .user-icon-container .tooltip {
                right: -50px;
            }

            .footer-content {
                margin-left: 25px;
                flex-direction: column;
                align-items: center;
            }

            .footer-section {
                min-width: 100%;
            }

            .social-links {
                justify-content: center;
            }
        }

        body {
            min-height: 100vh;
            background: var(--bg-color);
            margin: 0;
            padding: 0;
            color: var(--birusepuh);
        }

        .menu::-webkit-scrollbar {
            display: none;
        }

        .menu {
            z-index: 9999;
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            height: 100%;
            transition: .3s;
            scrollbar-width: none;
            overflow: hidden scroll;
            background: var(--primary-color);
            -ms-overflow-style: none;
            padding: 20px 0;
            backdrop-filter: blur(5px);
        }

        .menu-content {
            margin: 0;
        }

        .menu-content li {
            list-style: none;
            position: relative;
            margin-bottom: 1rem;
            border-radius: 2.3rem 0 0 2.3rem;
        }

        .menu-content li a {
            text-decoration: none;
            color: var(--acc-color);
            display: flex;
            align-items: center;
            padding: 0.5rem 0.1rem;
            position: relative;
            z-index: 1;
        }

        .menu-content li a span.material-symbols-outlined {
            padding: 0.6rem;
            font-size: 1.2rem;
            margin-right: 15px;
            border-radius: 50%;
            color: var(--acc-color);
            background: var(--birusepuh);
            transition: background 0.3s ease;
        }

        .menu-content li:hover a span.material-symbols-outlined {
            background: var(--meramera);
        }

        .menu-content li a:hover span.txt-sb {
            color: var(--sec-color);
        }

        .menu-content li:has(a span.active) a span.txt-sb {
            color: var(--sec-color);
        }

        .menu-content li:has(a span.active) {
            background: var(--bg-color);
        }

        .main-content {
            margin-left: 260px;
            transition: all 0.3s ease;
            width: calc(100% - 260px);
            max-width: 100%;
        }

        .user-icon-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }

        .user-icon {
            width: 50px;
            height: 50px;
            background: var(--birusepuh);
            color: var(--acc-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .user-icon:hover {
            background: var(--primary-color);
        }

        .tooltip {
            visibility: hidden;
            opacity: 0;
            position: absolute;
            bottom: 60px;
            right: 0;
            background: var(--birusepuh);
            color: var(--acc-color);
            padding: 8px 12px;
            border-radius: 5px;
            font-size: 14px;
            transition: opacity 0.3s ease, visibility 0.3s ease;
            white-space: nowrap;
        }

        .user-icon-container:hover .tooltip {
            visibility: visible;
            opacity: 1;
        }

        .menu-content li a {
            position: relative;
            overflow: hidden;
            padding: 0.5rem 0.6rem;
            display: flex;
            align-items: center;
            text-decoration: none;
            color: var(--acc-color);
            border-radius: 24px 0 0 24px;
        }

        .menu-content li a span.material-symbols-outlined {
            padding: 0.6rem;
            font-size: 1.2rem;
            margin-right: 15px;
            border-radius: 50%;
            color: var(--acc-color);
            background: var(--birusepuh);
            transition: all 0.3s ease;
            z-index: 1;
        }

        .menu-content li a span.txt-sb {
            transition: all 0.3s ease;
            z-index: 2;
            position: relative;
        }

        .menu-content li a:hover span.material-symbols-outlined {
            background: var(--meramera);
        }

        .menu-content li a:hover span.txt-sb {
            color: var(--sec-color);
            transform: translateX(10px);
        }

        .menu-content li a span.active {
            background: var(--meramera);
            color: var(--acc-color);
            transition: all 0.3s ease-in-out;
        }

        .menu-content li a:hover span.active {
            background: var(--birusepuh);
            color: var(--acc-color);
        }

        .menu-content li a::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--bg-color);
            z-index: 0;
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
            border-radius: 24px 0 0 24px;
        }

        .menu-content li a:hover::before {
            transform: scaleX(1);
        }

        .menu-content li a span.active::before {
            content: "";
            position: absolute;
            top: -15px;
            right: 0;
            width: 20px;
            height: 20px;
            background: transparent;
            border-bottom-left-radius: 20px;
            box-shadow: -5px 5px 0 5px var(--bg-color);
            z-index: -1;
            opacity: 1;
        }

        .menu-content li a span.active::after {
            content: "";
            position: absolute;
            bottom: -15px;
            right: 0;
            width: 20px;
            height: 20px;
            background: transparent;
            border-top-left-radius: 20px;
            box-shadow: -5px -5px 0 5px var(--bg-color);
            z-index: -1;
            opacity: 1;
        }

        .icon-micro {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.3s ease;
            margin-bottom: 1rem;
        }

        .icon-micro img {
            width: 35%;
        }

        .icon-micro hr {
            border: 0.2rem solid var(--acc-color);
            width: 100%;
            margin: 0 10px;
        }

        footer {
            background-color: var(--birusepuh);
            color: var(--acc-color);
            padding: 20px 0;
            margin-top: auto;
        }

        .footer-content {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .footer-section {
            flex: 1;
            min-width: 200px;
            margin-bottom: 20px;
        }

        .footer-section h4 {
            font-size: 1.2rem;
            margin-bottom: 15px;
            color: var(--primary-color);
        }

        .footer-section p {
            margin: 5px 0;
        }

        .footer-section a {
            color: var(--acc-color);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-section a:hover {
            color: var(--meramera);
        }

        .social-links {
            display: flex;
            gap: 10px;
        }

        .social-links a {
            font-size: 1.5rem;
            color: var(--acc-color);
            transition: color 0.3s ease;
        }

        .social-links a:hover {
            color: var(--meramera);
        }

        .footer-bottom {
            text-align: center;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid var(--primary-color);
        }

        .footer-bottom p {
            margin: 0;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <div id="app" class="d-flex">
        <nav class="menu">
            <div class="icon-micro">
                <img src="https://www.svgrepo.com/show/303239/raspberry-pi-logo.svg" alt="icon" class="img-fluid">
                <h1 class="fw-bold">
                    Inventory
                </h1>
                <hr>
            </div>
            <ul class="menu-content">
                <li>
                    <a href="{{ route('preview') }}">
                        <span
                            class="material-symbols-outlined {{ request()->routeIs('preview') ? 'active' : '' }}">home</span>
                        <span class="txt-sb">Home</span>
                    </a>
                </li>
                @if (Auth::check() && Auth::user()->roles[0]->id !== 3)
                    <li>
                        <a href="{{ route('dashboard') }}">
                            <span
                                class="material-symbols-outlined {{ request()->routeIs('dashboard') ? 'active' : '' }}">dashboard</span>
                            <span class="txt-sb">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('loans.dashboard') }}">
                            <span
                                class="material-symbols-outlined {{ request()->routeIs('loans.dashboard') ? 'active' : '' }}">inventory_2</span>
                            <span class="txt-sb">Pengambilan barang</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('boxes.index') }}">
                            <span
                                class="material-symbols-outlined {{ request()->routeIs('boxes.index') ? 'active' : '' }}">package</span>
                            <span class="txt-sb">Cb Box</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('categories.index') }}">
                            <span
                                class="material-symbols-outlined {{ request()->routeIs('categories.index') ? 'active' : '' }}">category</span>
                            <span class="txt-sb">Category / Projek</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('items.create') }}">
                            <span
                                class="material-symbols-outlined {{ request()->routeIs('items.create') ? 'active' : '' }}">add_box</span>
                            <span class="txt-sb">Tambah barang</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('toolscategories.index') }}">
                            <span
                                class="material-symbols-outlined {{ request()->routeIs('toolscategories.index') ? 'active' : '' }}">home_repair_service</span>
                            <span class="txt-sb">Kategori tool</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('tools.create') }}">
                            <span
                                class="material-symbols-outlined {{ request()->routeIs('tools.create') ? 'active' : '' }}">build</span>
                            <span class="txt-sb">Tambah alat</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('iBrgDtg') }}">
                            <span
                                class="material-symbols-outlined {{ request()->routeIs('iBrgDtg') ? 'active' : '' }}">hourglass_pause</span>
                            <span class="txt-sb">Barang datang</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('users.index') }}">
                            <span
                                class="material-symbols-outlined {{ request()->routeIs('users.index') ? 'active' : '' }}">group</span>
                            <span class="txt-sb">Kelola pengguna</span>
                        </a>
                    </li>
                @endif
                @guest
                    @if (Route::has('login'))
                        <li>
                            <a href="{{ route('login') }}">
                                <span
                                    class="material-symbols-outlined {{ request()->routeIs('login') ? 'active' : '' }}">login</span>
                                <span class="txt-sb">Login</span>
                            </a>
                        </li>
                    @endif
                @else
                    <li>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <span class="material-symbols-outlined">logout</span>
                            <span class="txt-sb">Logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                @endguest
            </ul>
        </nav>


        <!-- Main Content -->
        <div class="main-content py-4 px-2">
            @yield('content')
        </div>

        @auth
            <div class="user-icon-container">
                <div class="user-icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="tooltip">Halo {{ Auth::user()->name }}</div>
            </div>
        @endauth

    </div>
    <footer>
        <div class="footer-content">
            <!-- Bagian Tentang Kami -->
            <div class="footer-section">
                <h4>Tentang Kami</h4>
                <p>Kami adalah tim yang berdedikasi untuk </br> menyediakan solusi manajemen inventaris terbaik.</p>
            </div>

            <!-- Bagian Kontak -->
            <div class="footer-section">
                <h4>Kontak</h4>
                <p>Email: support@inventorymicro.com</p>
                <p>Telepon: +62 123 4567 890</p>
            </div>

            <!-- Bagian Tautan Cepat -->
            <div class="footer-section">
                <h4>Tautan Cepat</h4>
                <p><a href="{{ route('preview') }}">Beranda</a></p>
                <p><a href="{{ route('dashboard') }}">Dashboard</a></p>
                <p><a href="{{ route('login') }}">Login</a></p>
            </div>

            <!-- Bagian Sosial Media -->
            <div class="footer-section">
                <h4>Sosial Media</h4>
                <div class="social-links">
                    <a href="#" target="_blank"><i class="fab fa-facebook"></i></a>
                    <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
                    <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="#" target="_blank"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
        </div>

        <!-- Bagian Hak Cipta -->
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Inventory Micro Controller. All rights reserved.</p>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://uicdn.toast.com/tui.code-snippet/v1.5.2/tui-code-snippet.min.js"></script>
    <script src="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.min.js"></script>
    <script src="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.min.js"></script>
    <script src="https://uicdn.toast.com/tui-calendar/latest/tui-calendar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</body>

</html>
