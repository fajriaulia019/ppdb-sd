@extends('admin.layouts.app')

@section('title', 'Edit Data Pendaftar')  

@section('content')
<div class="container-fluid">
     <div class="card bg-primary text-white text-center mb-1 rounded-0 shadow-sm" style="border-bottom: 3px solid #0056b3;">
        <div class="card-body py-2">
            <h1 class="mb-4">Edit Data Pendaftar: {{ $pendaftar->nama_lengkap }}</h1>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form id="updatePendaftar-{{ $pendaftar->id }}" 
                method="POST" action="{{ route('admin.pendaftar.update', $pendaftar->id) }}">
                @csrf
                @method('PUT')
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="nisn" class="form-label">NISN:</label>
                        <input type="text" id="nisn" name="nisn" class="form-control @error('nisn') is-invalid @enderror" value="{{ old('nisn', $pendaftar->nisn) }}" required maxlength="10">
                        @error('nisn')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="nis_sekolah_display" class="form-label">NIS Sekolah:</label>
                        <input type="text" id="nis_sekolah_display" value="{{ $pendaftar->nis_sekolah ?? '- Belum Ada -' }}" class="form-control bg-light" readonly>
                        <input type="hidden" name="nis_sekolah" value="{{ $pendaftar->nis_sekolah }}">
                    </div>
                    <div class="col-md-6">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap Calon Siswa:</label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap', $pendaftar->nama_lengkap) }}" required>
                        @error('nama_lengkap')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir:</label>
                        <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" value="{{ old('tempat_lahir', $pendaftar->tempat_lahir) }}" required>
                        @error('tempat_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="tanggal_lahir" class="form-label">Tanggal lahir:</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir', $pendaftar->tanggal_lahir->format('Y-m-d')) }}" required>
                        @error('tanggal_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin:</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" class="form-control select2 @error('jenis_kelamin') is-invalid @enderror" required>
                            <option value="Laki-laki" {{ old('jenis_kelamin', $pendaftar->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin', $pendaftar->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label for="alamat" class="form-label">Alamat Lengkap:</label>
                        <textarea id="alamat" name="alamat" rows="3" class="form-control @error('alamat') is-invalid @enderror" required>{{ old('alamat', $pendaftar->alamat) }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="agama" class="form-label">Agama:</label>
                        <input type="text" id="agama" name="agama" class="form-control @error('agama') is-invalid @enderror" value="{{ old('agama', $pendaftar->agama) }}" required>
                        @error('agama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="nama_ayah" class="form-label">Nama Ayah:</label>
                        <input type="text" id="nama_ayah" name="nama_ayah" class="form-control @error('nama_ayah') is-invalid @enderror" value="{{ old('nama_ayah', $pendaftar->nama_ayah) }}" required>
                        @error('nama_ayah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="nama_ibu" class="form-label">Nama Ibu:</label>
                        <input type="text" id="nama_ibu" name="nama_ibu" class="form-control @error('nama_ibu') is-invalid @enderror" value="{{ old('nama_ibu', $pendaftar->nama_ibu) }}" required>
                        @error('nama_ibu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="nomor_telepon_orang_tua" class="form-label">Nomor Telepon Orang Tua:</label>
                        <input type="number" id="nomor_telepon_orang_tua" name="nomor_telepon_orang_tua" class="form-control @error('nomor_telepon_orang_tua') is-invalid @enderror" value="{{ old('nomor_telepon_orang_tua', $pendaftar->nomor_telepon_orang_tua) }}" required>
                        @error('nomor_telepon_orang_tua')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="status_pendaftaran" class="form-label">Status Pendaftaran:</label>
                        <select id="status_pendaftaran" name="status_pendaftaran" class="form-select @error('status_pendaftaran') is-invalid @enderror" required>
                            <option value="pending" {{ old('status_pendaftaran', $pendaftar->status_pendaftaran) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="diterima" {{ old('status_pendaftaran', $pendaftar->status_pendaftaran) == 'diterima' ? 'selected' : '' }}>Diterima</option>
                            <option value="ditolak" {{ old('status_pendaftaran', $pendaftar->status_pendaftaran) == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                        @error('status_pendaftaran')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="alasan_ditolak" class="form-label">Alasan Ditolak (jika ditolak):</label>
                        <textarea id="alasan_ditolak" name="alasan_ditolak" rows="2" class="form-control @error('alasan_ditolak') is-invalid @enderror">{{ old('alasan_ditolak', $pendaftar->alasan_ditolak) }}</textarea>
                        @error('alasan_ditolak')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 form-check form-switch mt-4 ms-3">
                        <input class="form-check-input" type="checkbox" id="sudah_daftar_ulang" name="sudah_daftar_ulang" value="1" {{ old('sudah_daftar_ulang', $pendaftar->sudah_daftar_ulang) ? 'checked' : '' }}>
                        <label class="form-check-label" for="sudah_daftar_ulang">Sudah Daftar Ulang</label>
                    </div>
                </div>

                <h2 class="h5 mb-3 mt-4">Dokumen Terunggah</h2>
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

                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.pendaftar.index') }} " class ="btn btn-success btn-lg mr-1"> Kembali
                    </a>
                    <button type="button"onclick="confirmAction({
                        formId: 'updatePendaftar-{{ $pendaftar->id }}',
                        title: 'Peringatan', 
                        text:'Simpan Perubahan',
                        confirmButton: 'Ya, Simpan!',
                        icon:'warning'
                        })"                    
                    class="btn btn-primary btn-lg">Update Pendaftar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection