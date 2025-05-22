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
        Schema::create('pembagian_klaim', function (Blueprint $table) {
            $table->id();
            $table->string('groups', 20)->nullable()->comment('kelompok, contoh: RITL, RJTL');
            $table->string('jenis', 20)->nullable()->comment('jenis, contoh: PISAU, NONPISAU');
            $table->string('grade', 20)->nullable()->comment('grade, contoh: GRADE1');
            $table->string('ppa', 50)->nullable()->comment('nama posisi, contoh: DPJP, PERAWAT');
            $table->decimal('value', 10, 4)->comment('nilai pembagian (persentase atau nominal)');
            $table->string('sumber', 50)->nullable()->comment('sumber data, contoh: VERIFIKASITOTAL');
            $table->string('flag', 20)->nullable()->comment('flag keterangan, contoh: NONE, KONSUL');
            $table->boolean('del')->default(false)->comment('status hapus, 0=aktif, 1=hapus');
            $table->string('sep', 50)->nullable()->comment('nomor SEP / Surat Eligibilitas Pasien');
            $table->string('id_detail_source', 50)->comment('id detail sumber klaim');
            $table->tinyInteger('cluster')->nullable()->comment('cluster pembagian klaim (1,2,3,4)');
            $table->integer('idxdaftar')->nullable()->comment('index pendaftaran pasien');
            $table->integer('nomr')->nullable()->comment('nomor rekam medis pasien');
            $table->date('tanggal')->comment('tanggal klaim / layanan');
            $table->text('keterangan')->nullable()->comment('keterangan tambahan');
            $table->timestamps();

            $table->foreign('id_detail_source')
                  ->references('id')
                  ->on('detail_source')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembagian_klaim');
    }
}; 