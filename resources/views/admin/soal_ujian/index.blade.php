@extends('admin.layouts.app')

@section('title', 'Manajemen Soal Ujian')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <form action="{{ route('admin.soal_ujian.index') }}" method="GET" class="d-flex w-50 me-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari soal atau jawaban..." value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
            </div>
        </form>
        <a href="{{ route('admin.soal_ujian.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Tambah Soal Baru
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Soal</th>
                            <th>Opsi A</th>
                            <th>Opsi B</th>
                            <th>Opsi C</th>
                            <th>Opsi D</th>
                            <th>Jawaban Benar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($soalUjians as $soal)
                            <tr>
                                <td>{{ $loop->iteration + ($soalUjians->currentPage() - 1) * $soalUjians->perPage() }}</td>
                                <td>{{ Str::limit($soal->soal, 100) }}</td>
                                <td>{{ $soal->opsi_a }}</td>
                                <td>{{ $soal->opsi_b }}</td>
                                <td>{{ $soal->opsi_c }}</td>
                                <td>{{ $soal->opsi_d }}</td>
                                <td class="fw-bold text-success">{{ $soal->jawaban_benar }}</td>
                                <td>
                                    <a href="{{ route('admin.soal_ujian.edit', $soal->id) }}" class="btn btn-sm btn-outline-info mb-1">Edit</a>
                                    <form id="deleteSoal-{{ $soal->id }}"
                                        action="{{ route('admin.soal_ujian.destroy', $soal->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin ingin menghapus soal ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmAction({
                                        formId:'deleteSoal-{{ $soal->id }}',
                                        title: 'Peringatan',
                                        text: 'Data yang sudah dihapus tidak bisa kembali!',
                                        confirmText: 'Ya, Hapus',
                                        icon: 'warning'
                                        })"
                                        class="btn btn-sm btn-outline-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">Belum ada soal ujian yang tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $soalUjians->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection