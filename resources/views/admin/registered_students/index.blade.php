@extends('admin.layouts.app')

@section('title', 'Daftar Siswa Terdaftar')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <form id="filterForm" action="{{ route('admin.registered_students.index') }}" method="GET" class="d-flex w-75 me-3">
            <div class="input-group">
                <select name="periode_id" id="periode_id" class="form-control">
                    <option value="">-- Pilih Periode Pendaftaran --</option>
                    @foreach ($periodes as $periode)
                        <option value="{{ $periode->id }}" {{ request('periode_id') == $periode->id ? 'selected' : '' }}>
                            {{ $periode->nama_periode }} ({{ $periode->tanggal_mulai->format('d/m/Y') }} - {{ $periode->tanggal_berakhir->format('d/m/Y') }})
                        </option>
                    @endforeach
                </select>
                <input type="text" name="search" class="form-control" placeholder="Cari NIS, Nama, Email, Telp..." value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-filter"></i> Filter</button>
            </div>
        </form>
        <a id="exportExcelButton" href="{{ route('admin.registered_students.export') }}" class="btn btn-success">
            <i class="fas fa-file-excel me-2"></i> Ekspor ke Excel
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Foto</th>
                            <th>NIS Sekolah</th>
                            <th>NISN</th>
                            <th>Nama Lengkap</th>
                            <th>Jenis Kelamin</th>
                            <th>Tanggal Lahir</th>
                            <th>Nomor Telepon Orang Tua</th>
                            <th>Pendapatan Orang Tua</th>
                            <th>Email Akun</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($registeredStudents as $student)
                            <tr>
                                <td>
                                    @if($student->foto_siswa)
                                        <img src="{{ Storage::url($student->foto_siswa) }}" alt="Foto Siswa" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                        <span class="text-muted small">No Foto</span>
                                    @endif
                                </td>
                                <td>{{ $student->nis_sekolah ?? '-' }}</td>
                                <td>{{ $student->nisn ?? '-' }}</td>
                                <td>{{ $student->nama_lengkap }}</td>
                                <td>{{ $student->jenis_kelamin }}</td>
                                <td>{{ $student->tanggal_lahir->format('d M Y') }}</td>
                                <td>{{ $student->nomor_telepon_orang_tua }}</td>
                                <td>{{ $student->pendapatan }}</td>
                                <td>{{ $student->user->email }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">Belum ada siswa yang terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $registeredStudents->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const periodeSelect = document.getElementById('periode_id');
    const exportExcelButton = document.getElementById('exportExcelButton');

    // Ketika dropdown periode berubah, otomatis submit form filter
    periodeSelect.addEventListener('change', function() {
        document.getElementById('filterForm').submit();
    });

    // Sesuaikan link export Excel saat periode dipilih
    exportExcelButton.addEventListener('click', function(event) {
        // Mencegah default action (langsung navigasi)
        event.preventDefault();

        const selectedPeriodeId = periodeSelect.value;
        let exportUrl = "{{ route('admin.registered_students.export') }}";

        if (selectedPeriodeId) {
            exportUrl += "?periode_id=" + selectedPeriodeId;
        }

        // Redirect ke URL export yang sudah disesuaikan
        window.location.href = exportUrl;
    });
});
</script>
@endsection