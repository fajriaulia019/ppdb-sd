@extends('admin.layouts.app')

@section('title', 'Edit Hasil Tes')

@section('content')
 <div class="card bg-primary text-white text-center mb-1 rounded-0 shadow-sm" style="border-bottom: 3px solid #0056b3;">
        <div class="card-body py-2">
            <h1 class="mb-4">Edit Data Pendaftar: {{ $testResult->user->name }}</h1>
        </div>
    </div>

<div class="card shadow-sm p-4">
    <form id="updateTes-{{ $testResult->id }}" 
        method="POST" action="{{ route('admin.testresults.update', $testResult->id) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nilai_keseluruhan" class="form-label">Nilai Keseluruhan (0-100):</label>
            <input type="number" id="nilai_keseluruhan" name="nilai_keseluruhan" min="0" max="100" class="form-control @error('nilai_keseluruhan') is-invalid @enderror" value="{{ old('nilai_keseluruhan', $testResult->nilai_keseluruhan) }}" required>
            @error('nilai_keseluruhan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="catatan_admin" class="form-label">Catatan Admin (opsional):</label>
            <textarea id="catatan_admin" name="catatan_admin" rows="4" class="form-control @error('catatan_admin') is-invalid @enderror">{{ old('catatan_admin', $testResult->catatan_admin) }}</textarea>
            @error('catatan_admin')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-end">
            <a href="{{ route('admin.testresults.index') }} " class ="btn btn-success mr-1"> Kembali
            </a>
            <button type="button" onclick="confirmAction({
            formId: 'updateTes-{{ $testResult->id }}',
            title: 'Peringatan', 
            text:'Simpan Perubahan',
            confirmButton: 'Ya, Simpan!',
            icon:'warning'
            })"
             class="btn btn-primary">Update Hasil Tes</button>
        </div>
        
    </form>
</div>
@endsection