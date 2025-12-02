<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pendaftars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Menghubungkan ke tabel users
            $table->string('nisn',10)->nullable()->unique(); // Tambahkan kolom NISN
            $table->string('nama_lengkap',255);
            $table->string('tempat_lahir',100);
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin',20);
            $table->text('alamat');
            $table->string('agama',50);
            $table->string('nama_ayah',255);
            $table->string('nama_ibu',255);
            $table->string('nomor_telepon_orang_tua',20);
            $table->string('kartu_keluarga_doc',255)->nullable(); // Path dokumen Kartu Keluarga
            $table->string('akta_lahir_doc',255)->nullable();     // Path dokumen Akta Lahir
            $table->string('ijazah_tk_doc',255)->nullable();      // Path dokumen Ijazah TK
            $table->string('status_pendaftaran',20)->default('pending'); // Status: pending, diterima, ditolak
            $table->boolean('sudah_daftar_ulang')->default(false); // Status daftar ulang
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftar');
    }
};