<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js"></script>

    <!-- Styles -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app" class="d-flex">
        <!-- Sidebar -->
        <nav class="p-3 text-white bg-dark vh-100" style="width: 250px; position: fixed;">
            <h4 class="fw-bold">Inventory<span class="text-danger">Micro</span></h4>
            <ul class="mt-4 nav flex-column">
                <li class="mb-2 nav-item">
                    <a href="{{ route('dashboard') }}" class="text-white nav-link">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="mb-2 nav-item">
                    <a href="{{ route('boxes.index') }}" class="text-white nav-link">
                        <i class="fas fa-box"></i> Cb Box
                    </a>
                </li>
                <li class="mb-2 nav-item">
                    <a href="{{ route('categories.index') }}" class="text-white nav-link">
                        <i class="fas fa-tags"></i> Category
                    </a>
                </li>
                <li class="mb-2 nav-item">
                    <a href="{{ route('stock.histories') }}" class="text-white nav-link">
                        <i class="fas fa-file-waveform"></i> Stock History
                    </a>
                </li>
                <li class="mb-2 nav-item">
                    <a href="{{ route('items.create') }}" class="text-white nav-link">
                        <i class="fas fa-plus-circle"></i> Add Items
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="container-fluid" style="margin-left: 240px;">
            <nav class="bg-white shadow-sm navbar navbar-expand-md navbar-light">
                <div class="container">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ms-auto">
                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                @endif

                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
            <main class="py-4">
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>