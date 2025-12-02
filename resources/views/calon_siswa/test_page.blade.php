@extends('layouts.siswa_dashboard')

@section('title', 'Test Online')

@section('content')
<div class="container-fluid">
    <div class="card card-outline card-primary mb-4 rounded-0">
        <div class="card-header text-center bg-primary text-white py-3">
            <h1 class="h4 mb-0">Test Online Pengetahuan Umum</h1>
        </div>
        <div class="card-body p-4">
            <p class="text-muted mb-4">Jawablah pertanyaan-pertanyaan di bawah ini dengan memilih salah satu opsi jawaban yang paling tepat. Anda harus menjawab semua soal yang tersedia.</p>

            <form method="POST" action="{{ route('test.submit') }}">
                @csrf

                @forelse ($soal_ujians as $soal)
                    <div class="card mb-4 border-secondary card-outline"> <div class="card-body">
                            <p class="fw-bold mb-3">Soal {{ $loop->iteration }}. {{ $soal->soal }}</p>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="{{ $soal->id }}" id="soal_{{ $soal->id }}_a" value="A" 
                                {{ old($soal->id) == 'A' ? 'checked' : '' }}>
                                <label class="form-check-label" for="soal_{{ $soal->id }}_a">
                                    {{ $soal->opsi_a }}
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="{{ $soal->id }}" id="soal_{{ $soal->id }}_b" value="B" 
                                {{ old($soal->id) == 'B' ? 'checked' : '' }}>
                                <label class="form-check-label" for="soal_{{ $soal->id }}_b">
                                    {{ $soal->opsi_b }}
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="{{ $soal->id }}" id="soal_{{ $soal->id }}_c" value="C" 
                                {{ old($soal->id) == 'C' ? 'checked' : '' }}>
                                <label class="form-check-label" for="soal_{{ $soal->id }}_c">
                                    {{ $soal->opsi_c }}
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="{{ $soal->id }}" id="soal_{{ $soal->id }}_d" value="D" 
                                {{ old($soal->id) == 'D' ? 'checked' : '' }}>
                                <label class="form-check-label" for="soal_{{ $soal->id }}_d">
                                    {{ $soal->opsi_d }}
                                </label>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-danger text-center" role="alert">
                        Maaf, belum ada soal ujian yang tersedia. Silakan hubungi administrator.
                    </div>
                @endforelse

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">Kirim Jawaban Tes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection