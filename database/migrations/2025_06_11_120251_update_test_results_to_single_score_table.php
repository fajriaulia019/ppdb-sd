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
        Schema::table('test_results', function (Blueprint $table) {
            $table->dropColumn(['nilai_matematika', 'nilai_bahasa_indonesia', 'nilai_ipa']);
            $table->integer('nilai_keseluruhan')->nullable()->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('test_results', function (Blueprint $table) {
            $table->dropColumn('nilai_keseluruhan');
            $table->integer('nilai_matematika')->nullable()->after('user_id');
            $table->integer('nilai_bahasa_indonesia')->nullable()->after('nilai_matematika');
            $table->integer('nilai_ipa')->nullable()->after('nilai_bahasa_indonesia');
        });
    }
};