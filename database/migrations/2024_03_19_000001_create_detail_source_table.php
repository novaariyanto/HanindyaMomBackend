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
        Schema::create('detail_source', function (Blueprint $table) {
            $table->id();
            $table->foreignId('remunerasi_source_id')->constrained('remunerasi_source')->onDelete('cascade');
            $table->string('kode_tarif');
            $table->string('nama_tarif');
            $table->integer('jumlah');
            $table->decimal('tarif', 15, 2);
            $table->decimal('total', 15, 2);
            $table->string('unit');
            $table->dateTime('tgl_tindakan');
            $table->string('idxdaftar')->nullable();
            $table->string('no_sep', 30)->nullable();
            $table->date('tgl_verifikasi')->nullable();
            $table->string('jenis', 50)->nullable();
            $table->decimal('biaya_riil_rs', 15, 2)->nullable();
            $table->decimal('biaya_diajukan', 15, 2)->nullable();
            $table->decimal('biaya_disetujui', 15, 2)->nullable();
            $table->string('nomr')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1: Aktif, 0: Nonaktif');
            $table->tinyInteger('status_pembagian_klaim')->default(0)->comment('0: Belum, 1: Sudah, 2: Gagal');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_source');
    }
}; 