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
        Schema::table('jtl_data', function (Blueprint $table) {
            $table->integer('allpegawai')->default(0)->after('nilai_indeks')->comment('Jumlah semua pegawai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jtl_data', function (Blueprint $table) {
            $table->dropColumn('allpegawai');
        });
    }
}; 