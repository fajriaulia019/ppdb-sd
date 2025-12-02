@extends('layouts.siswa_dashboard')

@section('title','Form Daftar Ulang')

@section('content')

<div class="card bg-primary text-white text-center mb-1 rounded-0 shadow-sm" style="border-bottom: 3px solid #0056b3;">
    <div class="card-body py-3">
        <h1 class="h4 mb-0">Pendaftaran Ulang Siswa</h1>
        <p class="mb-0 text-white-50">Silakan konfirmasi data Anda dan unggah foto terbaru.</p>
    </div>
</div>

<div class="container py-3">
    <div class="card shadow-sm p-4">
        <form method="POST" action="{{ route('daftarulang.submit') }}" enctype="multipart/form-data">
            @csrf

            <h5 class="mb-3 fw-bold text-primary">Konfirmasi Data Siswa</h5>
            <div class="row g-3 mb-4">
             <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <label for="nisn_confirm">NISN</label>
                        <input type="text" id="nisn_confirm" name="nisn_confirm" class="form-control" value="{{ $pendaftar->nisn ?? '-' }}" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <label for="nama_lengkap_confirm">Nama Lengkap</label>
                        <input type="text" id="nama_lengkap_confirm" name="nama_lengkap_confirm" class="form-control" value="{{ $pendaftar->nama_lengkap }}" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <label for="tanggal_lahir_confirm">Tanggal Lahir</label>
                        <input type="text" id="tanggal_lahir_confirm" name="tanggal_lahir_confirm" class="form-control" value="{{ $pendaftar->tanggal_lahir->format('d F Y') }}" readonly>
                    </div>
                </div>
            </div>

            <h5 class="mb-3 fw-bold text-primary mt-4">Unggah Foto Siswa (3x4)</h5>
            <p class="text-danger mb-4"><em>Harap unggah pas foto terbaru siswa (ukuran 3x4) dengan format JPG, JPEG, atau PNG, ukuran maksimal 2MB.*</em></p>
            <div class="row mb-4 align-items-start">
                <div class="col-md-3 text-center">
                    <div class="border border-secondary rounded p-1 d-inline-flex flex-column align-items-center justify-content-center position-relative" style="width: 120px; height: 160px; overflow: hidden;">
                        @if($pendaftar && $pendaftar->foto_siswa)
                            <img id="photoPreview" src="{{ Storage::url($pendaftar->foto_siswa) }}" alt="Preview Foto Siswa" class="img-fluid w-100 h-100 object-fit-cover" style="display: block;">
                            <i id="cameraIcon" class="fas fa-camera text-muted" style="font-size: 3.5rem; display: none;"></i>
                        @else
                            <img id="photoPreview" src="" alt="Preview Foto Siswa" class="img-fluid w-100 h-100 object-fit-cover" style="display: none;">
                            <i id="cameraIcon" class="fas fa-camera text-muted" style="font-size: 3.5rem; display: block;"></i>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <p class="mb-2"><strong>Pilih Foto *</strong></p>
                    <div class="input-group">
                        <input type="file" id="foto_siswa" name="foto_siswa" class="form-control @error('foto_siswa') is-invalid @enderror" >
                        <!-- <label class="input-group-text btn btn-outline-primary" for="foto_siswa" style="cursor: pointer;">Choose File</label>  -->
                        @error('foto_siswa')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <p class="mt-3 mb-2"><strong>Ketentuan Foto:</strong></p>
                    <ul class="list-unstyled small text-muted">
                        <li><i class="fas fa-check-circle text-success me-2"></i> Foto formal dengan latar belakang berwarna.</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Mengenakan seragam sekolah (jika ada) atau pakaian rapi.</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Pencahayaan yang baik dan jelas.</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Ukuran 3x4 cm (proporsi).</li>
                    </ul>
                </div>
                <div class="col-md-3">
                    </div>
            </div>

            <div class="text-center mt-4 p-3 alert alert-info">
                <p class="lead mb-0">Dengan menekan tombol "Konfirmasi Daftar Ulang", Anda menyatakan kesediaan untuk menjadi siswa resmi di SD kami dan bahwa data di atas sudah benar.</p>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-success btn-lg">Konfirmasi Daftar Ulang</button>
            </div>
        </form>
    </div>
</div>

@endsection