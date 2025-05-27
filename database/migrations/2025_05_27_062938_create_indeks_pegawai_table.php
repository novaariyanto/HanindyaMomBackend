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
        Schema::create('indeks_pegawai', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255);
            $table->string('nip', 30);
            $table->date('tmt_cpns');
            $table->date('tmt_di_rs');
            $table->string('masa_kerja_di_rs', 50);
            $table->decimal('indeks_masa_kerja', 4, 2);
            $table->string('kualifikasi_pendidikan', 100);
            $table->integer('indeks_kualifikasi_pendidikan');
            $table->integer('indeks_resiko');
            $table->integer('indeks_emergency');
            $table->string('jabatan', 255);
            $table->integer('indeks_posisi_unit_kerja');
            $table->string('ruang', 100);
            $table->integer('indeks_jabatan_tambahan');
            $table->integer('indeks_performa');
            $table->decimal('total', 5, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indeks_pegawai');
    }
};
