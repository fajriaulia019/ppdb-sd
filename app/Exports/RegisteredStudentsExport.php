<?php

namespace App\Exports;

use App\Models\Pendaftar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon; // Impor Carbon

class RegisteredStudentsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $periodeId;

    public function __construct(int $periodeId = null)
    {
        $this->periodeId = $periodeId;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Pendaftar::with('user')
                        ->where('status_pendaftaran', 'diterima')
                        ->where('sudah_daftar_ulang', true);

        // Jika periodeId diberikan, filter berdasarkan created_at (tanggal pendaftaran)
        if ($this->periodeId) {
            $periode = \App\Models\PeriodePendaftaran::find($this->periodeId);
            if ($periode) {
                // Filter pendaftar yang dibuat dalam rentang tanggal periode
                $query->whereBetween('created_at', [
                    $periode->tanggal_mulai->startOfDay(),
                    $periode->tanggal_berakhir->endOfDay()
                ]);
            }
        }

        return $query->orderBy('nis_sekolah', 'asc')->get();
    }

    /**
     * Menambahkan baris header di file Excel.
     */
    public function headings(): array
    {
        return [
            'NIS Sekolah',
            'NISN',
            'Nama Lengkap',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Alamat',
            'Agama',
            'Nama Ayah',
            'Nama Ibu',
            'No. Telepon Orang Tua',
            'Pendapatan',
            'Email Akun',
        ];
    }

    /**
     * Memetakan setiap baris data ke format yang diinginkan untuk Excel.
     */
    public function map($pendaftar): array
    {
        return [
            $pendaftar->nis_sekolah ?? '-',
            $pendaftar->nisn ?? '-',
            $pendaftar->nama_lengkap,
            $pendaftar->tanggal_lahir->format('d M Y'),
            $pendaftar->jenis_kelamin,
            $pendaftar->alamat,
            $pendaftar->agama,
            $pendaftar->nama_ayah,
            $pendaftar->nama_ibu,
            $pendaftar->nomor_telepon_orang_tua,
            $pendaftar->pendapatan,
            $pendaftar->user->email,
        ];
    }
}