<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; // Penting: Impor model User

class Pendaftar extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'no_pendaftaran',
        'nisn',
        'nis_sekolah',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'agama',
        'nama_ayah',
        'nama_ibu',
        'nomor_telepon_orang_tua',
        'pendapatan',
        'kartu_keluarga_doc',
        'akta_lahir_doc',
        'ijazah_tk_doc',
        'foto_siswa',
        'status_pendaftaran',
        'alasan_ditolak',
        'sudah_daftar_ulang',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'sudah_daftar_ulang' => 'boolean',
    ];

    /**
     * Get the user that owns the Pendaftar.
     * (Relasi satu-ke-satu terbalik)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}