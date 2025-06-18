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
        Schema::create('jtl_pegawai_hasil', function (Blueprint $table) {
            $table->id();
            $table->string('id_pegawai', 50);
            $table->unsignedBigInteger('remunerasi_source');
            $table->string('nik', 20);
            $table->string('nama_pegawai', 255);
            $table->unsignedBigInteger('unit_kerja_id')->nullable();
            $table->decimal('dasar', 18, 2)->default(0.00);
            $table->decimal('kompetensi', 18, 2)->default(0.00);
            $table->decimal('resiko', 18, 2)->default(0.00);
            $table->decimal('emergensi', 18, 2)->default(0.00);
            $table->decimal('posisi', 18, 2)->default(0.00);
            $table->decimal('kinerja', 18, 2)->default(0.00);
            $table->decimal('jumlah', 18, 2)->default(0.00);
            $table->decimal('nilai_indeks', 18, 2)->default(0.00)->comment('Nilai indeks dari jtl_data');
            $table->decimal('jtl_bruto', 18, 2)->default(0.00)->comment('jumlah * nilai_indeks');
            $table->decimal('pajak', 18, 2)->default(0.00)->comment('Persentase pajak');
            $table->decimal('potongan_pajak', 18, 2)->default(0.00)->comment('Nilai potongan pajak');
            $table->decimal('jtl_net', 18, 2)->default(0.00)->comment('jtl_bruto - potongan_pajak');
            $table->string('rekening', 50)->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('id_pegawai');
            $table->index('remunerasi_source');
            $table->index(['id_pegawai', 'remunerasi_source']);
            
            // Foreign keys
            $table->foreign('remunerasi_source')
                  ->references('id')
                  ->on('remunerasi_source')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jtl_pegawai_hasil');
    }
};
