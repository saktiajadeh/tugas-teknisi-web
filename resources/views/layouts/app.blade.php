<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sistem Informasi Manajemen Tugas Teknisi</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Icon -->
    <link rel="icon" type="image/x-icon" sizes="114x114" href="{{ asset('img/icon-logo.png') }}?v={{ date('YmdHis') }}">

    <!-- Styles -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @guest
            <main id="wrapperLogin" class="w-100 py-4">
                @yield('content')
            </main>
        @else

        <aside id="sidenav">
            <nav class="accordion" id="sidenavAccordion">
                <!-- Sidenav Brand-->
                <div class="sidenav-brand px-3">
                    <a class="py-2" href="{{ url('/home') }}">
                        <img src="{{ asset('img/logo-square-invert.png') }}" alt="">
                        {{-- <img src="{{ asset('img/logo-persegi-panjang-invert.png') }}" alt=""> --}}
                    </a>
                </div>
                <div class="sidenav-menu">
                    <div class="nav">
                        <div class="sidenav-menu-heading">Menu Utama</div>
                        <a class="nav-link" href="{{ url('/home') }}">
                            <div class="nav-link-icon"><i class="ion-home"></i></div>
                            <span>Beranda</span>
                        </a>
                        <a class="nav-link" href="#">
                            <div class="nav-link-icon"><i class="ion-person-stalker"></i></div>
                            <span>Teknisi</span>
                        </a>
                        <a class="nav-link" href="#">
                            <div class="nav-link-icon"><i class="ion-person-stalker"></i></div>
                            <span>Pelanggan</span>
                        </a>
                        <a class="nav-link" href="#">
                            <div class="nav-link-icon"><i class="ion-gear-b"></i></div>
                            <span>Kategori Jasa</span>
                        </a>
                        <a class="nav-link" href="#">
                            <div class="nav-link-icon"><i class="ion-clipboard"></i></div>
                            <span>Tugas Teknisi</span>
                        </a>
                        <a class="nav-link" href="#">
                            <div class="nav-link-icon"><i class="ion-ios-book"></i></div>
                            <span>Laporan Tugas</span>
                        </a>
                        {{-- <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="nav-link-icon"><i class="ion-ios-book"></i></div>
                            Master Data
                            <div class="sidenav-collapse-arrow"><i class="ion-chevron-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sidenav-menu-nested nav">
                                <a class="nav-link" href="#">Data Customer</a>
                                <a class="nav-link" href="#">Data Teknisi</a>
                            </nav>
                        </div> --}}
                    </div>
                </div>
            </nav>
        </aside>

        <main id="wrapper">
            <nav id="topnav" class="navbar navbar-expand">
                <!-- Sidebar Toggle-->
                <button class="btn btn-link btn-md order-1" id="sidebarToggle" href="#!">
                    <i class="ion-navicon-round"></i>
                </button>
                <!-- Navbar-->
                <ul class="navbar-nav ms-auto me-1">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                            <i class="fas fa-user fa-fw"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                {{ __('Keluar') }}
                            </a>
    
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </nav>

            <section id="mainContent" class="py-4">
                @yield('content')
            </section>

            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-center small">
                        <div class="text-muted">Sistem Informasi Manajemen Tugas Teknisi &copy; 2022</div>
                    </div>
                </div>
            </footer>
        </main>
        @endguest
    </div>
</body>
</html>
