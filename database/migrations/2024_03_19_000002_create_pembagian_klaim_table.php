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
            $table->string('groups', 20);
            $table->string('jenis', 20);
            $table->string('grade', 20);
            $table->string('ppa', 50);
            $table->decimal('value', 10, 4);
            $table->string('sumber', 50);
            $table->string('flag', 20);
            $table->boolean('del')->default(false);
            $table->string('sep', 50);
            $table->string('id_detail_source', 50);
            $table->tinyInteger('cluster');
            $table->integer('idxdaftar');
            $table->integer('nomr');
            $table->date('tanggal');
            $table->timestamps();
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