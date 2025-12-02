@extends('layouts.siswa_dashboard')

@section('title', 'Status Pendaftaran')

@section('content')
<div class="container-fluid">
    <div class="card card-outline card-primary mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Status Pendaftaran Anda</h5>
        </div>
        <div class="card-body">
            @if ($pendaftar)
                <div class="table-responsive mb-4">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th style="width: 30%;">No. Pendaftaran</th>
                                <td>{{ $pendaftar->no_pendaftaran ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>NISN</th>
                                <td>{{ $pendaftar->nisn ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>NIS Sekolah</th>
                                <td>
                                    @if($pendaftar->nis_sekolah)
                                        <span class="fw-bold text-success">{{ $pendaftar->nis_sekolah }}</span>
                                    @else
                                        <span class="text-muted">- Belum Ada -</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Nama Lengkap</th>
                                <td>{{ $pendaftar->nama_lengkap }}</td>
                            </tr>
                            <tr>
                                <th>Status Pendaftaran</th>
                                <td>
                                    <span class="badge 
                                        @if ($pendaftar->status_pendaftaran == 'pending') badge-warning text-dark
                                        @elseif ($pendaftar->status_pendaftaran == 'diterima') badge-success
                                        @else badge-danger @endif">
                                        {{ ucfirst($pendaftar->status_pendaftaran) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Sudah Daftar Ulang</th>
                                <td>
                                    <span class="badge {{ $pendaftar->sudah_daftar_ulang ? 'badge-success' : 'badge-danger' }}">
                                        {{ $pendaftar->sudah_daftar_ulang ? 'Ya' : 'Belum' }}
                                    </span>
                                </td>
                            </tr>
                            @if ($pendaftar->status_pendaftaran == 'ditolak' && $pendaftar->alasan_ditolak)
                            <tr>
                                <th>Alasan Ditolak</th>
                                <td class="text-danger fst-italic">{{ $pendaftar->alasan_ditolak }}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <h6 class="mb-3">Status Dokumen & Foto Siswa</h6>
                <div class="table-responsive mb-4">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th style="width: 30%;">Kartu Keluarga (KK)</th>
                                <td>
                                    @if ($pendaftar->kartu_keluarga_doc)
                                        <a href="{{ Storage::url($pendaftar->kartu_keluarga_doc) }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat Dokumen</a>
                                    @else
                                        <span class="text-danger">Belum diunggah</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Akta Lahir</th>
                                <td>
                                    @if ($pendaftar->akta_lahir_doc)
                                        <a href="{{ Storage::url($pendaftar->akta_lahir_doc) }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat Dokumen</a>
                                    @else
                                        <span class="text-danger">Belum diunggah</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Ijazah TK/Sederajat</th>
                                <td>
                                    @if ($pendaftar->ijazah_tk_doc)
                                        <a href="{{ Storage::url($pendaftar->ijazah_tk_doc) }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat Dokumen</a>
                                    @else
                                        <span class="text-danger">Belum diunggah</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Foto Siswa</th>
                                <td>
                                    @if ($pendaftar->foto_siswa)
                                        <img src="{{ Storage::url($pendaftar->foto_siswa) }}" alt="Foto Siswa" class="img-thumbnail mb-2" style="width: 100px; height: 100px; object-fit: cover;">
                                        <a href="{{ Storage::url($pendaftar->foto_siswa) }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat Foto</a>
                                    @else
                                        <span class="text-danger">Belum diunggah</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="text-center mt-3">
                    @if ($pendaftar->status_pendaftaran == 'diterima' && !$pendaftar->sudah_daftar_ulang)
                        <p class="lead text-success fw-bold mb-3">Selamat! Pendaftaran Anda telah DITERIMA. Silakan lanjutkan ke proses daftar ulang.</p>
                        <a href="{{ route('daftarulang.show') }}" class="btn btn-info btn-lg text-white">Daftar Ulang Sekarang</a>
                    @elseif ($pendaftar->status_pendaftaran == 'pending' && !$testResult && $pendaftar->kartu_keluarga_doc && $pendaftar->akta_lahir_doc && $pendaftar->ijazah_tk_doc)
                        <p class="lead text-info fw-bold mb-3">Status pendaftaran Anda masih PENDING. Dokumen lengkap. Silakan ikuti tes seleksi.</p>
                        <a href="{{ route('test.show') }}" class="btn btn-secondary btn-lg">Ikuti Tes Sekarang</a>
                    @elseif ($pendaftar->status_pendaftaran == 'pending' && $testResult && $pendaftar->kartu_keluarga_doc && $pendaftar->akta_lahir_doc && $pendaftar->ijazah_tk_doc)
                        <p class="lead text-info fw-bold mb-3">Status pendaftaran Anda masih PENDING. Dokumen dan hasil tes sudah diterima, menunggu review dari admin.</p>
                    @elseif ($pendaftar->status_pendaftaran == 'pending' && (!$pendaftar->kartu_keluarga_doc || !$pendaftar->akta_lahir_doc || !$pendaftar->ijazah_tk_doc))
                        <p class="lead text-danger fw-bold mb-3">Status pendaftaran Anda masih PENDING. Dokumen persyaratan belum lengkap. Silakan lengkapi formulir pendaftaran Anda.</p>
                        <a href="{{ route('pendaftar.create') }}" class="btn btn-primary btn-lg">Lengkapi Formulir</a>
                    @elseif ($pendaftar->status_pendaftaran == 'ditolak')
                        <p class="lead text-danger fw-bold mb-3">Mohon maaf, pendaftaran Anda telah DITOLAK.</p>
                        @if($pendaftar->alasan_ditolak)
                            <p class="text-danger fst-italic mb-3">Alasan: "{{ $pendaftar->alasan_ditolak }}"</p>
                        @endif
                        <p class="text-muted">Silakan hubungi bagian administrasi sekolah untuk informasi lebih lanjut.</p>
                    @elseif ($pendaftar->status_pendaftaran == 'diterima' && $pendaftar->sudah_daftar_ulang)
                        <p class="lead text-success fw-bold mb-3">Selamat! Anda telah resmi menjadi siswa baru. Proses pendaftaran Anda sudah LENGKAP.</p>
                        <a href="{{ route('pendaftar.cetak_bukti') }}" class="btn btn-primary btn-lg mt-3"><i class="fas fa-print me-2"></i> Cetak Bukti Pendaftaran</a>
                    @endif
                </div>
            </div>
        @else
            <div class="alert alert-info text-center lead" role="alert">Anda belum mengisi formulir pendaftaran. Silakan <a href="{{ route('pendaftar.create') }}" class="text-primary">isi formulir</a> terlebih dahulu.</div>
        @endif
    </div>

    <div class="card card-outline card-info">
        <div class="card-header">
            <h5 class="card-title mb-0">Hasil Tes Anda</h5>
        </div>
        <div class="card-body">
            @if ($testResult)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th style="width: 30%;">Nilai Keseluruhan</th>
                                <td>{{ $testResult->nilai_keseluruhan }}</td>
                            </tr>
                            @if($testResult->catatan_admin)
                            <tr>
                                <th>Catatan Admin</th>
                                <td>{{ $testResult->catatan_admin }}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted text-center lead">Anda belum mengikuti tes.</p>
                @if ($pendaftar && $pendaftar->status_pendaftaran == 'pending' && $pendaftar->kartu_keluarga_doc && $pendaftar->akta_lahir_doc && $pendaftar->ijazah_tk_doc)
                    <p class="text-muted text-center mt-3">Silakan ikuti <a href="{{ route('test.show') }}" class="text-primary">tes seleksi</a> untuk melanjutkan proses pendaftaran.</p>
                @endif
            @endif
            <hr class="my-4"> 
             <div class="text-center">
                <a href="{{ route('dashboard') }}" class="btn btn-success"><i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard</a>
            </div>
        </div>
    </div>
</div>
@endsection