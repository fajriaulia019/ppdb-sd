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
        Schema::create('soal_ujians', function (Blueprint $table) {
            $table->id();
            $table->text('soal'); 
            $table->string('opsi_a',255); 
            $table->string('opsi_b',255); 
            $table->string('opsi_c',255); 
            $table->string('opsi_d',255); 
            $table->string('jawaban_benar',2); 
            $table->timestamps();
        });
    }

  
    public function down(): void
    {
        Schema::dropIfExists('soal_ujians');
    }
};