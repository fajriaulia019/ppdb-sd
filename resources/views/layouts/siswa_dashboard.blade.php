<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PPDB Siswa | @yield('title')</title>
    <link rel="icon" href="{{ asset('image/background/tutwurihandayani.png') }}" type="image/x-icon">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('css/chat_bubble.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/siswa_dashboard.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.0/dist/sweetalert2.min.css">

    <style>
        .sidebar-mini .main-sidebar .nav-link .nav-icon {
            margin-left: -5px;
        }

        .main-header .navbar-nav .nav-item .nav-link[data-widget="pushmenu"] {
            font-size: 1.5rem;
        }

        .navbar-page-title {
            font-size: 1.25rem;
            font-weight: bold;
            color: #343a40;
            margin-left: 0.5rem;

        }

        @media (max-width: 575.98px) {
            .navbar-page-title {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-flex align-items-center"> 
                   
                    <span
                        class="nav-link navbar-page-title">@yield('title')
                    </span>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <span class="nav-link text-muted">Halo, {{ Auth::user()->name }}</span>
                </li>
                <li class="nav-item">
                    <form id="siswaLogout"
                    action="{{ route('logout') }}" method="POST" class="nav-link d-inline">
                        @csrf
                        <button type="button" onclick="confirmAction({
                        formId: 'siswaLogout',
                        title: 'Peringatan',
                        text: 'Anda yakin ingin keluar dari sesi ini?',
                        confirmButton: 'Ya, keluar',
                        icon:'warning'})"
                        class="btn btn-sm btn-outline-danger">Logout</button>
                    </form>
                </li>
            </ul>
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{ route('dashboard') }}" class="brand-link">
                 <img src="{{ asset('image/background/tutwurihandayani.png') }}" alt="sekolah Logo" 
                        class="img-circle elevation-4" style="opacity: .8" width="50" height="50"> </img>
                <span class="brand-text font-weight-light">PPDB Online</span>
            </a>

            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="info">
                        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}"
                                class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('pendaftar.create') }}"
                                class="nav-link {{ request()->routeIs('pendaftar.create') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-file-alt"></i>
                                <p>Formulir Pendaftaran</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('test.show') }}"
                                class="nav-link {{ request()->routeIs('test.show') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tasks"></i>
                                <p>Test Online</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('pendaftar.status') }}"
                                class="nav-link {{ request()->routeIs('pendaftar.status') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-info-circle"></i>
                                <p>Status Pendaftaran</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('daftarulang.show') }}"
                                class="nav-link {{ request()->routeIs('daftarulang.show') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-check-double"></i>
                                <p>Daftar Ulang</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link"
                               onclick="confirmAction({
                                formId: 'logout-form-siswa',
                                title: 'Peringatan',
                                text: 'Anda yakin ingin keluar dari sesi ini?',
                                confirmButton: 'Ya, keluar',
                                icon:'warning'
                                })">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>Keluar</p>
                            </a>
                            <form id="logout-form-siswa" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">

                </div>
            </div>
            <div class="content">
                <div class="container-fluid">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if (session('info'))
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            {{ session('info') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
        <footer class="main-footer bg-dark text-white text-center py-4 mt-5">
            <div class="container">
                <p class="mb-1">Hubungi admin PPDB :</p>
                    <a href="https://wa.me/62812345678" target="_blank" class="btn btn-success btn-sm">
                    <i class="fab fa-whatsapp"></i> WhatsApp
                    </a>
                <p class="mb-0">&copy; {{ date('Y') }} SDN 30 Bukik Kandung. Semua Hak Dilindungi.</p>
            </div>
        </footer>
    </div>

     <a href="https://wa.me/62812345678" target="_blank" class="chat-bubble" title="Chat dengan Admin PPDB">
        <div class="chat-tooltip">Chat dengan Admin PPDB</div>
        <i class="fab fa-whatsapp whatsapp-icon"></i>
        <div class="chat-notification">!</div>
    </a>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('js/upload_foto.js') }}"></script>
    <script src="{{ asset('js/sweetalert_notification.js') }}"></script>
    @include('sweetalert::alert')

</body>
</html>