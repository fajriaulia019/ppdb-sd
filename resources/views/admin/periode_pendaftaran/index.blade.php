@extends('admin.layouts.app')

@section('title', 'Manajemen Periode Pendaftaran')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <form action="{{ route('admin.periode_pendaftaran.index') }}" method="GET" class="d-flex w-50 me-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari periode..." value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
            </div>
        </form>
        <a href="{{ route('admin.periode_pendaftaran.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Tambah Periode Baru
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Periode</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Berakhir</th>
                            <th>Status Aktif</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($periodes as $periode)
                            <tr>
                                <td>{{ $loop->iteration + ($periodes->currentPage() - 1) * $periodes->perPage() }}</td>
                                <td>{{ $periode->nama_periode }}</td>
                                <td>{{ $periode->tanggal_mulai->format('d F Y') }}</td>
                                <td>{{ $periode->tanggal_berakhir->format('d F Y') }}</td>
                                <td>
                                    <span class="badge {{ $periode->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $periode->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.periode_pendaftaran.edit', $periode->id) }}" class="btn btn-sm btn-outline-info me-1">Edit</a>
                                    <form id="delPeriod-{{ $periode->id }}"
                                        action="{{ route('admin.periode_pendaftaran.destroy', $periode->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin ingin menghapus periode ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmAction({
                                        formId: 'delPeriod-{{ $periode->id }}',
                                        title: 'Peringatan',
                                        text: 'Data yang sudah dihapus tidak bisa kembali lagi!',
                                        confirmButton: 'Ya, Hapus',
                                        icon: 'warning'
                                        })"
                                        class="btn btn-sm btn-outline-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">Belum ada periode pendaftaran yang tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $periodes->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection