@extends('layouts.siswa_dashboard')

@section('title', 'Formulir Pendaftaran')

@section('content')

    <div class="card bg-primary text-white text-center mb-0 rounded-0 shadow-sm" style="border-bottom: 3px solid #0056b3;">
        <div class="card-body py-3">
            <h1 class="h4 mb-0">Formulir Pendaftaran Siswa Baru</h1>
        </div>
    </div>

    <div class="container py-3">
        <div class="card shadow-sm p-4">
            <form method="POST" action="{{ route('pendaftar.store') }}" enctype="multipart/form-data">
                @csrf

                <h4 class="mb-3 fw-bold text-primary">Data Pribadi</h4>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <label for="nama_lengkap">Nama Lengkap *</label>
                            <input type="text" id="nama_lengkap" name="nama_lengkap"
                                class="form-control @error('nama_lengkap') is-invalid @enderror"
                                value="{{ old('nama_lengkap') }}" required placeholder="Nama Lengkap">
                            @error('nama_lengkap')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <label for="nisn">NISN *</label>
                            <input type="number" id="nisn" name="nisn"
                                class="form-control @error('nisn') is-invalid @enderror" value="{{ old('nisn') }}" required
                                maxlength="10" placeholder="NISN">
                            @error('nisn')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <label for="tempat_lahir">Tempat Lahir *</label>
                            <input type="text" id="tempat_lahir" name="tempat_lahir"
                                class="form-control @error('tempat_lahir') is-invalid @enderror"
                                value="{{ old('tempat_lahir') }}" required placeholder="Tempat Lahir">
                            @error('tempat_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <label for="tanggal_lahir">Tanggal Lahir *</label>
                            <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                                class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                value="{{ old('tanggal_lahir') }}" required>
                            @error('tanggal_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3"> <label for="jenis_kelamin" class="form-label">Jenis Kelamin *</label>
                            <select id="jenis_kelamin" name="jenis_kelamin"
                                class="form-control select2 @error('jenis_kelamin') is-invalid @enderror" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                    Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="agama" class="form-label d-block">Agama *</label>
                        <select id="agama" name="agama" class="form-control select2 @error('agama') is-invalid @enderror"
                            required>
                            <option value="">Pilih Agama</option>
                            <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen Protestan" {{ old('agama') == 'Kristen Protestan' ? 'selected' : '' }}>
                                Kristen Protestan</option>
                            <option value="Kristen Katolik" {{ old('agama') == 'Kristen Katolik' ? 'selected' : '' }}>Kristen
                                Katolik</option>
                            <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                            <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                            <option value="Lainnya" {{ old('agama') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('agama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <div class="form-floating">
                            <label for="alamat">Alamat Lengkap *</label>
                            <textarea id="alamat" name="alamat" rows="3"
                                class="form-control @error('alamat') is-invalid @enderror" required
                                placeholder="Alamat Lengkap">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <h4 class="mb-3 fw-bold text-primary">Data Orang Tua</h4>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <label for="nama_ayah">Nama Ayah *</label>
                            <input type="text" id="nama_ayah" name="nama_ayah"
                                class="form-control @error('nama_ayah') is-invalid @enderror" value="{{ old('nama_ayah') }}"
                                required placeholder="Nama Ayah">
                            @error('nama_ayah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <label for="nama_ibu">Nama Ibu *</label>
                            <input type="text" id="nama_ibu" name="nama_ibu"
                                class="form-control @error('nama_ibu') is-invalid @enderror" value="{{ old('nama_ibu') }}"
                                required placeholder="Nama Ibu">
                            @error('nama_ibu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <label for="nomor_telepon_orang_tua">Nomor Telepon Orang Tua *</label>
                            <input type="number" id="nomor_telepon_orang_tua" name="nomor_telepon_orang_tua"
                                class="form-control @error('nomor_telepon_orang_tua') is-invalid @enderror"
                                value="{{ old('nomor_telepon_orang_tua') }}" required placeholder="Nomor Telepon Orang Tua">
                            @error('nomor_telepon_orang_tua')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="pendapatan" class="form-label d-block">Pendapatan Orang Tua *</label>
                        <select id="pendapatan" name="pendapatan" class="form-control select2 @error('pendapatan') is-invalid @enderror"
                            required>
                            <option value="">Pilih Pendapatan</option>
                            <option value="<1000000" {{ old('pendapatan') == '<1000000' ? 'selected' : '' }}>Dibawah 1 juta</option>
                            <option value="1000000-2500000" {{ old('pendapatan') == '1000000-2500000' ? 'selected' : '' }}>
                                1 juta sampai 2,5 juta</option>
                            <option value="2500000-5000000" {{ old('pendapatan') == '2500000-5000000' ? 'selected' : '' }}>2,5 juta sampai 5 juta</option>
                            <option value=">5000000" {{ old('pendapatan') == '>5000000' ? 'selected' : '' }}>Diatas 5 juta</option>
                        </select>
                        @error('agama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <h4 class="mb-3 fw-bold text-primary">Upload Dokumen Persyaratan</h4>
                <p class="text-danger mb-4">Harap unggah dokumen dalam format PDF, JPG, JPEG, atau PNG dengan ukuran maksimal
                    2MB.</p>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="kartu_keluarga_doc" class="form-label">Kartu Keluarga (KK) *</label>
                        <input type="file" id="kartu_keluarga_doc" name="kartu_keluarga_doc"
                            class="form-control @error('kartu_keluarga_doc') is-invalid @enderror" required>
                        @error('kartu_keluarga_doc')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="akta_lahir_doc" class="form-label">Akta Lahir *</label>
                        <input type="file" id="akta_lahir_doc" name="akta_lahir_doc"
                            class="form-control @error('akta_lahir_doc') is-invalid @enderror" required>
                        @error('akta_lahir_doc')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="ijazah_tk_doc" class="form-label">Ijazah TK/Sederajat *</label>
                        <input type="file" id="ijazah_tk_doc" name="ijazah_tk_doc"
                            class="form-control @error('ijazah_tk_doc') is-invalid @enderror" required>
                        @error('ijazah_tk_doc')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary btn-lg">Kirim Pendaftaran</button>
                </div>
            </form>
        </div>
    </div>
@endsection