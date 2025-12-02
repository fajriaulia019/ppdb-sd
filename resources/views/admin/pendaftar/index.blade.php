@extends('admin.layouts.app')

@section('title', 'Data Pendaftar')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <form action="{{ route('admin.pendaftar.index') }}" method="GET" class="d-flex w-50 me-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari NISN, Nama, Email, Telp..."
                        value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>NISN</th>
                                <th>Nama Lengkap</th>
                                <th>Email Akun</th>
                                <th>Hasil Tes</th>
                                <th>Status Pendaftaran</th>
                                <th>Daftar Ulang</th>
                                <th>Dokumen</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pendaftar as $data)
                                <tr>
                                    <td>{{ $data->nisn ?? '-' }}</td>
                                    <td>{{ $data->nama_lengkap }}</td>
                                    <td>{{ $data->user->email }}</td>
                                    <td>
                                        @if($data->user->testResult)
                                            <span
                                                class="fw-bold {{ $data->user->testResult->nilai_keseluruhan >= 70 ? 
                                                'text-success' : 'text-danger' }}">{{ $data->user->testResult->nilai_keseluruhan }}</span>
                                        @else
                                            <span class="text-muted">- Belum Tes -</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge 
                                                        @if ($data->status_pendaftaran == 'pending') bg-warning text-dark
                                                        @elseif ($data->status_pendaftaran == 'diterima') bg-success
                                                        @else bg-danger @endif">
                                            {{ ucfirst($data->status_pendaftaran) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $data->sudah_daftar_ulang ? 'bg-success' : 'bg-danger' }}">
                                            {{ $data->sudah_daftar_ulang ? 'Ya' : 'Belum' }}
                                        </span>
                                    </td>
                                    <td class="text-sm">
                                        @if ($data->kartu_keluarga_doc)
                                            <a href="{{ Storage::url($data->kartu_keluarga_doc) }}" target="_blank"
                                                class="d-block text-primary text-decoration-none small">KK</a>
                                        @else <span class="text-danger small">KK (X)</span> @endif

                                        @if ($data->akta_lahir_doc)
                                            <a href="{{ Storage::url($data->akta_lahir_doc) }}" target="_blank"
                                                class="d-block text-primary text-decoration-none small">Akta</a>
                                        @else <span class="text-danger small">Akta (X)</span> @endif

                                        @if ($data->ijazah_tk_doc)
                                            <a href="{{ Storage::url($data->ijazah_tk_doc) }}" target="_blank"
                                                class="d-block text-primary text-decoration-none small">Ijazah TK</a>
                                        @else <span class="text-danger small">Ijazah (X)</span> @endif
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column align-items-start">
                                            <a href="{{ route('admin.pendaftar.edit', $data->id) }}"
                                                class="btn btn-sm btn-outline-info mb-1 w-100">Edit</a>
                                            <form id="delete-form-{{ $data->id }}"
                                                action="{{ route('admin.pendaftar.destroy', $data->id) }}" method="POST"
                                                class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <button type="button" onclick="confirmAction({
                                                formId: 'delete-form-{{ $data->id }}',
                                                title: 'Hapus Data Pendaftar',
                                                text: 'Data ini akan dihapus permanen dan tidak bisa dikembalikan.',
                                                confirmButton: 'Ya, Hapus',
                                                icon: 'error'
                                            })"
                                                class="btn btn-sm btn-outline-danger mb-1 w-100 ">Hapus</button>

                                            @if ($data->status_pendaftaran == 'pending' || $data->status_pendaftaran == 'ditolak')
                                                <form id="verifikasis-{{ $data->id }}"
                                                    action="{{ route('admin.pendaftar.verifikasi', $data->id) }}" method="POST"
                                                    class="d-inline mb-1 w-100">
                                                    @csrf
                                                    <button type="button"
                                                    onclick="confirmAction({
                                                    formId: 'verifikasis-{{ $data->id}}',
                                                    title: 'Verifikasi Pendaftar',
                                                    text: 'Data ini akan diterima dan akan di proses lanjutnya.',
                                                    confirmButton: 'Ya, Verifikasi',
                                                    icon: 'warning'
                                                    })"
                                                    class="btn btn-sm btn-success w-100">Verifikasi</button>
                                                </form>
                                            @endif
                                            @if ($data->status_pendaftaran == 'diterima')
                                                <form id="batalkan-{{ $data->id }}"
                                                    action="{{ route('admin.pendaftar.batalkan-verifikasi', $data->id) }}"
                                                    method="POST" class="d-inline mb-1 w-100">
                                                    @csrf
                                                    <button
                                                    onclick= "confirmAction({
                                                    formId: 'batalkan-{{ $data->id}}',
                                                    title: 'Batalkan Verifikasi Pendaftar',
                                                    text: 'Data ini akan dibatalkan dan akan kembali ke status awal.',
                                                    confirmButton: 'Batalkan, Verifikasi!',
                                                    icon: 'warning'
                                                    })" 
                                                    type="button" class="btn btn-sm btn-warning w-100">Batalkan</button>
                                                </form>
                                            @endif
                                            @if ($data->status_pendaftaran == 'pending' || $data->status_pendaftaran == 'diterima')
                                                <button type="button" onclick="showRejectModal('{{ $data->id }}')"
                                                    class="btn btn-sm btn-danger w-100">Tolak</button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">Tidak ada data pendaftar yang tersedia.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $pendaftar->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">Tolak Pendaftaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="rejectForm" method="POST" action="">
                    <div class="modal-body">
                        @csrf
                        <p class="text-muted">Masukkan alasan penolakan untuk pendaftar ini:</p>
                        <div class="form-group">
                            <textarea name="alasan_ditolak" rows="4"
                                class="form-control @error('alasan_ditolak') is-invalid @enderror"
                                placeholder="Contoh: Dokumen tidak lengkap, Usia tidak sesuai, Hasil tes di bawah standar."></textarea>
                            @error('alasan_ditolak')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Tolak Pendaftar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if ($errors->has('alasan_ditolak'))
        <script>
             window.addEventListener('DOMContentLoaded', () => {
                const rejectModal = new bootstrap.Modal(document.getElementById('rejectModal'));
                rejectModal.show();
             });
        </script>
    @endif
@endsection