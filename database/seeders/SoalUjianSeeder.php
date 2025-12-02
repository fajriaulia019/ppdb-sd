<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SoalUjian; // Penting: Impor model SoalUjian

class SoalUjianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $soal = [
            [
                'soal' => 'Berapakah hasil dari 7 + 5?',
                'opsi_a' => '10',
                'opsi_b' => '12',
                'opsi_c' => '13',
                'opsi_d' => '15',
                'jawaban_benar' => 'B',
            ],
            [
                'soal' => 'Apa ibukota negara Indonesia?',
                'opsi_a' => 'Bandung',
                'opsi_b' => 'Surabaya',
                'opsi_c' => 'Jakarta',
                'opsi_d' => 'Medan',
                'jawaban_benar' => 'C',
            ],
            [
                'soal' => 'Huruf pertama dari abjad adalah?',
                'opsi_a' => 'B',
                'opsi_b' => 'A',
                'opsi_c' => 'C',
                'opsi_d' => 'D',
                'jawaban_benar' => 'B',
            ],
            [
                'soal' => 'Warna dasar pelangi adalah?',
                'opsi_a' => 'Merah, Kuning, Hijau',
                'opsi_b' => 'Biru, Putih, Hitam',
                'opsi_c' => 'Ungu, Oranye, Cokelat',
                'opsi_d' => 'Pink, Abu-abu, Turquoise',
                'jawaban_benar' => 'A',
            ],
            [
                'soal' => 'Hewan yang bisa terbang adalah?',
                'opsi_a' => 'Kucing',
                'opsi_b' => 'Ikan',
                'opsi_c' => 'Burung',
                'opsi_d' => 'Sapi',
                'jawaban_benar' => 'C',
            ],
            [
                'soal' => 'Alat untuk menulis adalah?',
                'opsi_a' => 'Sendok',
                'opsi_b' => 'Pensil',
                'opsi_c' => 'Gunting',
                'opsi_d' => 'Garpu',
                'jawaban_benar' => 'B',
            ],
            [
                'soal' => 'Berapakah hasil dari 9 - 3 ',
                'opsi_a' => '7',
                'opsi_b' => '4',
                'opsi_c' => '5',
                'opsi_d' => '6',
                'jawaban_benar' => 'D',
            ],
            [
                'soal' => 'Hari setelah Minggu adalah?',
                'opsi_a' => 'Selasa',
                'opsi_b' => 'Sabtu',
                'opsi_c' => 'Jumat',
                'opsi_d' => 'Senin',
                'jawaban_benar' => 'D',
            ],
            [
                'soal' => 'Bendera Indonesia berwarna?',
                'opsi_a' => 'Hijau dan Putih',
                'opsi_b' => 'Merah dan Putih',
                'opsi_c' => 'Biru dan Kuning',
                'opsi_d' => 'Hitam dan Merah',
                'jawaban_benar' => 'B',
            ],
            [
                'soal' => 'Buah yang biasanya berwarna kuning dan asam adalah?',
                'opsi_a' => 'Apel',
                'opsi_b' => 'Pisang',
                'opsi_c' => 'Lemon',
                'opsi_d' => 'Mangga',
                'jawaban_benar' => 'C',
            ],
        ];

        foreach ($soal as $item) {
            SoalUjian::create($item);
        }
    }
}