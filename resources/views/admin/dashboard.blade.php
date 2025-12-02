@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalPendaftar }}</h3>
                    <p>Total Pendaftar</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('admin.pendaftar.index') }}" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $pendingPendaftar }}</h3>
                    <p>Pendaftar Pending</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
                <a href="{{ route('admin.pendaftar.index', ['search' => 'pending']) }}" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $diterimaPendaftar }}</h3>
                    <p>Pendaftar Diterima</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <a href="{{ route('admin.pendaftar.index', ['search' => 'diterima']) }}" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $ditolakPendaftar }}</h3>
                    <p>Pendaftar Ditolak</p>
                </div>
                <div class="icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <a href="{{ route('admin.pendaftar.index', ['search' => 'ditolak']) }}" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        </div>
    <div class="row">
        <div class="col-lg-6 col-md-12">
            <div class="small-box bg-gradient-info">
                <div class="inner">
                    <h3>{{ $sudahDaftarUlang }}</h3>
                    <p>Sudah Daftar Ulang</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-check"></i>
                </div>
                <a href="{{ route('admin.registered_students.index') }}" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-6 col-md-12">
            <div class="small-box bg-gradient-warning">
                <div class="inner">
                    <h3>{{ $belumDaftarUlang }}</h3>
                    <p>Belum Daftar Ulang (Diterima)</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <a href="{{ route('admin.pendaftar.index', ['search' => 'diterima', 'sudah_daftar_ulang' => 'false']) }}" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Manajemen Pendaftar</h3>
                </div>
                <div class="card-body">
                    <p class="card-text text-muted">Kelola data pendaftar calon siswa, termasuk verifikasi, tolak, edit, dan hapus.</p>
                    <a href="{{ route('admin.pendaftar.index') }}" class="btn btn-primary">Lihat Data Pendaftar</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-success card-outline">
                <div class="card-header">
                    <h3 class="card-title">Manajemen Hasil Tes</h3>
                </div>
                <div class="card-body">
                    <p class="card-text text-muted">Tinjau dan perbarui nilai tes seleksi calon siswa.</p>
                    <a href="{{ route('admin.testresults.index') }}" class="btn btn-success">Lihat Hasil Tes</a>
                </div>
            </div>
        </div>
    </div>

</div>@endsection