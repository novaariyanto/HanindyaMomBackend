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
        Schema::create('jtl_pegawai_indeks', function (Blueprint $table) {
            $table->id();
            $table->string('id_pegawai', 50);
            $table->decimal('dasar', 18, 2)->default(0.00);
            $table->decimal('kompetensi', 18, 2)->default(0.00);
            $table->decimal('resiko', 18, 2)->default(0.00);
            $table->decimal('emergensi', 18, 2)->default(0.00);
            $table->decimal('posisi', 18, 2)->default(0.00);
            $table->decimal('kinerja', 18, 2)->default(0.00);
            $table->decimal('jumlah', 18, 2)->default(0.00);
            $table->timestamps();
            
            // Index untuk performa
            $table->index('id_pegawai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jtl_pegawai_indeks');
    }
}; 