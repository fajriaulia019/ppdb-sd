@extends('layouts.siswa_dashboard')

@section('title', 'Review Hasil Tes')

@section('content')
<div class="container-fluid">
    <div class="card card-outline card-info mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Ringkasan Tes</h5>
        </div>
        <div class="card-body">
            @if($testResult)
                <p class="lead">Nilai Keseluruhan: <span class="fw-bold {{ $testResult->nilai_keseluruhan >= 70 ? 'text-success' : 'text-danger' }}">{{ $testResult->nilai_keseluruhan }}</span></p>
                <p class="text-muted">Status: {{ $pendaftar->status_pendaftaran == 'diterima' ? 'Diterima' : ($pendaftar->status_pendaftaran == 'ditolak' ? 'Ditolak' : 'Menunggu Review Admin') }}</p>
                @if($testResult->catatan_admin)
                    <p class="text-muted">Catatan Admin: {{ $testResult->catatan_admin }}</p>
                @endif
                <hr>
                <h5 class="mt-4 mb-3">Detail Jawaban (Untuk Pembelajaran)</h5>
                @foreach($soal_ujians as $soal)
                    <div class="mb-3">
                        <p class="fw-bold mb-1">Soal {{ $loop->iteration }}. {{ $soal->soal }}</p>
                        <p class="mb-0">Jawaban Benar: <span class="fw-bold text-success">{{ $soal->jawaban_benar }}</span> ({{ $soal->{'opsi_' . strtolower($soal->jawaban_benar)} }})</p>
                    </div>
                @endforeach
            @else
                <p class="lead text-muted text-center">Hasil tes tidak ditemukan. Anda belum mengikuti tes atau terjadi kesalahan.</p>
                <div class="text-center">
                    <a href="{{ route('test.show') }}" class="btn btn-primary mt-3">Mulai Tes</a>
                </div>
            @endif
             <hr class="my-4"> 
             <div class="text-center">
                <a href="{{ route('dashboard') }}" class="btn btn-success"><i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard</a>
            </div>
        </div>
    </div>
</div>
@endsection