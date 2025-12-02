@extends('admin.layouts.app')

@section('title', 'Hasil Tes Pendaftar')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <form action="{{ route('admin.testresults.index') }}" method="GET" class="d-flex w-50">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari NISN, Nama, Email..." value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
        </div>
    </form>
</div>

<div class="card shadow-sm p-4">
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>NISN</th>
                    <th>Nama Pendaftar</th>
                    <th>Email Akun</th>
                    <th>Nilai Keseluruhan</th>
                    <th>Catatan Admin</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($testResults as $result)
                    <tr>
                        <td>{{ $result->user->pendaftar->nisn ?? '-' }}</td>
                        <td>{{ $result->user->name }}</td>
                        <td>{{ $result->user->email }}</td>
                        <td>
                            @if($result->nilai_keseluruhan !== null)
                                <span class="fw-bold {{ $result->nilai_keseluruhan >= 70 ? 'text-success' : 'text-danger' }}">{{ $result->nilai_keseluruhan }}</span>
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $result->catatan_admin ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.testresults.edit', $result->id) }}" class="btn btn-sm btn-outline-info">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">Tidak ada hasil tes yang tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        {{ $testResults->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection