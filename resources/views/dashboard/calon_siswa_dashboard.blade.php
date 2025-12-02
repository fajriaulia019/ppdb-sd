@extends('layouts.siswa_dashboard')

@section('title', 'Dashboard Siswa')

@section('content')
    <div class="container-fluid">
        <div class="card bg-primary text-white text-center mb-2 rounded-3 shadow-sm" style="border-bottom: 2px solid #095ab1ff;">
            <div class="card-body py-3">
                <h3 class="mb-4"><b>Selamat Datang, {{ Auth::user()->name }}!</b></h3>
                <p class="lead text-muted text-white ">Pantau proses pendaftaran PPDB Anda di sini.</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="small-box bg-gradient-primary">
                    <div class="inner">
                        <p>No. Pendaftaran</p>
                        <h3>{{ Auth::user()->pendaftar ? Auth::user()->pendaftar->no_pendaftaran ?? 'N/A' : 'Belum Mendaftar' }}</h3> 
                    </div>
                    <div class="icon">
                        <i class="fas fa-id-card"></i>
                    </div>
                    <a href="{{ Auth::user()->pendaftar ? route('pendaftar.status') : route('pendaftar.create') }}" class="small-box-footer">
                        Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-8 col-md-6">
                <div class="card card-outline card-success">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="fas fa-info-circle me-2"></i> Status Pendaftaran</h5>
                    </div>
                    <div class="card-body">
                        @if(Auth::user()->pendaftar)
                            @php
                                $pendaftar = Auth::user()->pendaftar;
                                $currentStatus = $pendaftar->status_pendaftaran;
                                $sudahDaftarUlang = $pendaftar->sudah_daftar_ulang;
                                $testResult = Auth::user()->testResult;

                                $isFormLengkap = $pendaftar->nama_lengkap;
                                $isBerkasVerified = ($currentStatus == 'diterima' || ($currentStatus == 'pending' && $pendaftar->kartu_keluarga_doc && $pendaftar->akta_lahir_doc && $pendaftar->ijazah_tk_doc && !$testResult));
                                $isTestSelesai = $testResult !== null;
                                $isPengumumanDiterima = ($currentStatus == 'diterima');
                                $isPengumumanDitolak = ($currentStatus == 'ditolak');
                                $isNISSekolahDiberikan = $pendaftar->nis_sekolah !== null;
                            @endphp
                            <p class="card-text">Status Anda saat ini: <span class="fw-bold">{{ ucfirst($currentStatus) }}</span></p>

                            <div class="status-timeline mt-3">
                                <ul class="list-unstyled">
                                    <li class="{{ $isFormLengkap ? 'completed' : 'active' }}">Formulir Pendaftaran</li>
                                    <li class="{{ ($isBerkasVerified || $currentStatus == 'diterima' || $currentStatus == 'ditolak') ? 'completed' : (($isFormLengkap && $currentStatus == 'pending') ? 'active' : '') }}">Verifikasi Berkas</li>
                                    <li class="{{ ($isTestSelesai || $isPengumumanDiterima || $isPengumumanDitolak) ? 'completed' : (($isBerkasVerified && $currentStatus == 'pending' && !$isTestSelesai) ? 'active' : '') }}">Test Online</li>
                                    <li class="{{ ($isPengumumanDiterima || $isPengumumanDitolak) ? 'completed' : ($isTestSelesai ? 'active' : '') }}">Pengumuman Hasil Seleksi</li>
                                    <li class="{{ $sudahDaftarUlang ? 'completed' : ($isPengumumanDiterima ? 'active' : '') }}">Daftar Ulang</li>
                                    <li class="{{ $isNISSekolahDiberikan ? 'completed' : (($sudahDaftarUlang && $currentStatus == 'diterima' && !$isNISSekolahDiberikan) ? 'active' : '') }}">Penerbitan NIS Sekolah</li>
                                </ul>
                            </div>
                        @else
                            <p class="card-text text-muted">Anda belum mengisi formulir pendaftaran.</p>
                            <a href="{{ route('pendaftar.create') }}" class="btn btn-primary btn-sm mt-2">Isi Formulir Pendaftaran</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
            <div class="col">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="far fa-edit me-2"></i> Formulir Pendaftaran</h5>
                    </div>
                    <div class="card-body">
                        @if(Auth::user()->pendaftar && Auth::user()->pendaftar->nama_lengkap)
                            <span class="badge badge-success">Lengkap</span>
                            <p class="card-text mt-2 text-muted">Data pribadi, orang tua, dan dokumen pendukung telah terisi.</p>
                            <a href="{{ route('pendaftar.status') }}" class="btn btn-outline-primary btn-sm">Lihat Detail</a>
                        @else
                            <span class="badge badge-warning">Belum Lengkap</span>
                            <p class="card-text mt-2 text-muted">Silakan lengkapi formulir pendaftaran.</p>
                            <a href="{{ route('pendaftar.create') }}" class="btn btn-primary btn-sm">Isi Formulir</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card card-outline card-warning">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="fas fa-tasks me-2"></i> Test Online</h5>
                    </div>
                    <div class="card-body">
                        @php
                            $pendaftar = Auth::user()->pendaftar;
                            $testResult = Auth::user()->testResult;
                             $canTakeTest = $pendaftar && !$testResult && ($pendaftar
                             ->status_pendaftaran == 'pending' || $pendaftar
                             ->status_pendaftaran == 'diterima');
                            $hasCompletedTest = $testResult !== null;
                        @endphp

                        @if($hasCompletedTest)
                            <span class="badge badge-success">Selesai</span>
                            <p class="card-text mt-2 text-muted">Anda telah menyelesaikan tes online. Hasil: <strong>{{ $testResult->nilai_keseluruhan }}</strong></p>
                            <a href="{{ route('pendaftar.test_review') }}" class="btn btn-outline-success btn-sm">Lihat Hasil</a>
                        @elseif($canTakeTest)
                            <span class="badge badge-info">Tersedia</span>
                            <p class="card-text mt-2 text-muted">Anda dapat mengikuti tes online sekarang.</p>
                            <a href="{{ route('test.show') }}" class="btn btn-warning btn-sm">Mulai Tes</a>
                        @else
                            <span class="badge badge-secondary">Belum Tersedia</span>
                            <p class="card-text mt-2 text-muted">Tes online akan tersedia setelah dokumen terverifikasi atau jika status Anda pending.</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card card-outline card-info"> <div class="card-header">
                        <h5 class="card-title mb-0"><i class="fas fa-check-double me-2"></i> Daftar Ulang</h5>
                    </div>
                    <div class="card-body">
                        @php
                            $pendaftar = Auth::user()->pendaftar;
                            $canDaftarUlang = $pendaftar && $pendaftar->status_pendaftaran == 'diterima' && !$pendaftar->sudah_daftar_ulang;
                        @endphp
                        @if($canDaftarUlang)
                            <span class="badge badge-success">Tersedia</span>
                            <p class="card-text mt-2 text-muted">Silakan lakukan daftar ulang sesuai dengan pengumuman.</p>
                            <a href="{{ route('daftarulang.show') }}" class="btn btn-success btn-sm">Daftar Ulang</a>
                        @elseif($pendaftar && $pendaftar->sudah_daftar_ulang)
                            <span class="badge badge-primary">Sudah Selesai</span>
                            <p class="card-text mt-2 text-muted">Proses daftar ulang Anda sudah selesai.</p>
                            <a href="{{ route('pendaftar.cetak_bukti') }}" class="btn btn-outline-primary btn-sm">Cetak Bukti</a>
                        @else
                            <span class="badge badge-secondary">Belum Tersedia</span>
                            <p class="card-text mt-2 text-muted">Daftar ulang tersedia setelah pengumuman hasil seleksi.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection