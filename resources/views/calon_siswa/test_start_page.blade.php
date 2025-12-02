@extends('layouts.siswa_dashboard')

@section('title', 'Mulai Test Online')

@section('content')
<div class="container-fluid">
    <div class="card card-outline card-primary mb-4 rounded-0">
        <div class="card-header text-center bg-primary text-white py-3">
            <h1 class="h4 mb-0">Test Online Pengetahuan Umum</h1>
        </div>
        <div class="card-body text-center p-5">
            <div class="mb-4">
                <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
            </div>
            <h3 class="mb-4">Selamat Datang di Test Online</h3>
            <p class="lead text-muted mb-4">Test ini terdiri dari {{ $total_soal }} soal dengan berbagai jenis pertaan. 
                Pastikan Anda telah siap sebelum memulai.</p>
            
            <div class="row justify-content-center mb-5 g-3">
                <div class="col-md-4 col-6">
                    <div class="card h-100 border-primary">
                        <div class="card-body d-flex flex-column justify-content-center align-items-center">
                            <i class="fas fa-question-circle fa-2x text-primary mb-2"></i>
                            <p class="mb-0 fw-bold">{{ $total_soal }} Soal</p>
                            <small class="text-muted">Jumlah Soal</small>
                        </div>
                    </div>
                </div>
            </div>

            <a href="{{ route('test.show', ['start_test' => true]) }}" class="btn btn-primary btn-lg px-5 py-3 rounded-pill">Mulai Test</a>
        </div>
    </div>
</div>
@endsection