@extends('admin.layouts.app')

@section('title', 'Edit Periode Pendaftaran')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-body">
            <form id="editPeriod-{{ $periodePendaftaran->id }}" 
                action="{{ route('admin.periode_pendaftaran.update', $periodePendaftaran->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="nama_periode" class="form-label">Nama Periode:</label>
                    <input type="text" id="nama_periode" name="nama_periode" class="form-control @error('nama_periode') is-invalid @enderror" value="{{ old('nama_periode', $periodePendaftaran->nama_periode) }}" required>
                    @error('nama_periode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai:</label>
                        <input type="date" id="tanggal_mulai" name="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror" value="{{ old('tanggal_mulai', $periodePendaftaran->tanggal_mulai->format('Y-m-d')) }}" required>
                        @error('tanggal_mulai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="tanggal_berakhir" class="form-label">Tanggal Berakhir:</label>
                        <input type="date" id="tanggal_berakhir" name="tanggal_berakhir" class="form-control @error('tanggal_berakhir') is-invalid @enderror" value="{{ old('tanggal_berakhir', $periodePendaftaran->tanggal_berakhir->format('Y-m-d')) }}" required>
                        @error('tanggal_berakhir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $periodePendaftaran->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Aktifkan Periode Ini (akan menonaktifkan periode lain yang sedang aktif)</label>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.periode_pendaftaran.index') }}" class="btn btn-success mr-1"> Kembali</a>
                    <button type="button" onclick="confirmAction({
                    formId: 'editPeriod-{{ $periodePendaftaran->id }}',
                    title: 'Peringatan',
                    text: 'Anda yakin ingin mengubah periode pendaftaran ini?',
                    confirmButton: 'Ya, Perbaharui',
                    icon:'warning'
                    })"
                     class="btn btn-primary">Update Periode</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection