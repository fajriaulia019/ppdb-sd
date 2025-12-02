@extends('admin.layouts.app')

@section('title', 'Edit Soal Ujian')

@section('content')
<div class="container-fluid">
     <div class="card bg-primary text-white text-center mb-1 rounded-0 shadow-sm" style="border-bottom: 3px solid #0056b3;">
        <div class="card-body py-2">
            <h1 class="mb-4">Edit Soal: No.  {{ $soalUjian->id }}</h1>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form id="editSoal-{{ $soalUjian->id }}"
                action="{{ route('admin.soal_ujian.update', $soalUjian->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="soal" class="form-label">Teks Soal:</label>
                    <textarea id="soal" name="soal" rows="4" class="form-control @error('soal') is-invalid @enderror" required>{{ old('soal', $soalUjian->soal) }}</textarea>
                    @error('soal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="opsi_a" class="form-label">Opsi A:</label>
                        <input type="text" id="opsi_a" name="opsi_a" class="form-control @error('opsi_a') is-invalid @enderror" value="{{ old('opsi_a', $soalUjian->opsi_a) }}" required>
                        @error('opsi_a')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="opsi_b" class="form-label">Opsi B:</label>
                        <input type="text" id="opsi_b" name="opsi_b" class="form-control @error('opsi_b') is-invalid @enderror" value="{{ old('opsi_b', $soalUjian->opsi_b) }}" required>
                        @error('opsi_b')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="opsi_c" class="form-label">Opsi C:</label>
                        <input type="text" id="opsi_c" name="opsi_c" class="form-control @error('opsi_c') is-invalid @enderror" value="{{ old('opsi_c', $soalUjian->opsi_c) }}" required>
                        @error('opsi_c')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="opsi_d" class="form-label">Opsi D:</label>
                        <input type="text" id="opsi_d" name="opsi_d" class="form-control @error('opsi_d') is-invalid @enderror" value="{{ old('opsi_d', $soalUjian->opsi_d) }}" required>
                        @error('opsi_d')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="jawaban_benar" class="form-label">Jawaban Benar (A/B/C/D):</label>
                    <select id="jawaban_benar" name="jawaban_benar" class="form-select @error('jawaban_benar') is-invalid @enderror" required>
                        <option value="">Pilih Opsi</option>
                        <option value="A" {{ old('jawaban_benar', $soalUjian->jawaban_benar) == 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ old('jawaban_benar', $soalUjian->jawaban_benar) == 'B' ? 'selected' : '' }}>B</option>
                        <option value="C" {{ old('jawaban_benar', $soalUjian->jawaban_benar) == 'C' ? 'selected' : '' }}>C</option>
                        <option value="D" {{ old('jawaban_benar', $soalUjian->jawaban_benar) == 'D' ? 'selected' : '' }}>D</option>
                    </select>
                    @error('jawaban_benar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.soal_ujian.index') }}" class="btn btn-success mr-1">Kembali</a>
                    <button type="button" onclick="confirmAction({
                        formId: 'editSoal-{{ $soalUjian->id }}',
                        title: 'Peringatan', 
                        text:'Simpan Perubahan',
                        confirmButton: 'Ya, Simpan!',
                        icon:'warning'
                        })" 
                     class="btn btn-primary">Update Soal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection