<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin PPDB SD | @yield('title')</title>

  <link rel="icon" href="{{ asset('image/background/tutwurihandayani.png') }}" type="image/x-icon">

  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.0/dist/sweetalert2.min.css">
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-flex align-items-center"> <span class="nav-link navbar-page-title">@yield('title')</span>
        </li>
      </ul>

      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <span class="nav-link text-muted">Halo, {{ Auth::user()->name }}</span>
        </li>
        <li class="nav-item">
          <form id="logOut"
              action="{{ route('logout') }}" method="POST" class="nav-link d-inline">
            @csrf
            <button type="button" onclick="confirmAction({
                    formId: 'logOut',
                    title: 'Peringatan',
                    text: 'Anda yakin ingin keluar dari sesi ini?',
                    confirmButton: 'Ya, keluar',
                    icon:'warning'
                    })"
            class="btn btn-sm btn-outline-danger">Logout</button>
          </form>
        </li>
      </ul>
    </nav>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{ asset('image/background/tutwurihandayani.png') }}" alt="sekolah Logo" 
           class="img-circle elevation-4" style="opacity: .8" width="50" height="50"> </img>
        <span class="brand-text font-weight-light">PPDB SD Admin</span>
      </a>

      <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="info">
            <a href="#" class="d-block">{{ Auth::user()->name }}</a>
          </div>
        </div>

        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
              <a href="{{ route('admin.dashboard') }}"
                class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.periode_pendaftaran.index') }}"
                class="nav-link {{ request()->routeIs('admin.periode_pendaftaran.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-calendar-alt"></i>
                <p>Periode Pendaftaran</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.soal_ujian.index') }}"
                class="nav-link {{ request()->routeIs('admin.soal_ujian.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-question-circle"></i>
                <p>Manajemen Soal</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.pendaftar.index') }}"
                class="nav-link {{ request()->routeIs('admin.pendaftar.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-users"></i>
                <p>Data Pendaftar</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.testresults.index') }}"
                class="nav-link {{ request()->routeIs('admin.testresults.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-poll"></i>
                <p>Hasil Tes</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.registered_students.index') }}"
                class="nav-link {{ request()->routeIs('admin.registered_students.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-user-check"></i>
                <p>Siswa Terdaftar</p>
              </a>
            </li>


          </ul>
        </nav>
      </div>
    </aside>

    <div class="content-wrapper">
      <div class="content-header">

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
    <footer class="main-footer">
      <div class="float-right d-none d-sm-inline">
        Anything you want
      </div>
      <strong>Copyright &copy; {{ date('Y') }} <a href="#">PPDB SD</a>.</strong> All rights reserved.
    </footer>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
  <script src="{{ asset('js/admin_custom.js') }}"></script>
  <script src="{{ asset('js/sweetalert_notification.js') }}"></script>
 @include('sweetalert::alert')
</body>

</html>