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
        Schema::create('jam_kerjas', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('shift_id'); // Foreign key

            // Kolom untuk hari Senin
            $table->time('senin_masuk')->nullable();
            $table->time('senin_pulang')->nullable();

            // Kolom untuk hari Selasa
            $table->time('selasa_masuk')->nullable();
            $table->time('selasa_pulang')->nullable();

            // Kolom untuk hari Rabu
            $table->time('rabu_masuk')->nullable();
            $table->time('rabu_pulang')->nullable();

            // Kolom untuk hari Kamis
            $table->time('kamis_masuk')->nullable();
            $table->time('kamis_pulang')->nullable();

            // Kolom untuk hari Jumat
            $table->time('jumat_masuk')->nullable();
            $table->time('jumat_pulang')->nullable();

            // Kolom untuk hari Sabtu
            $table->time('sabtu_masuk')->nullable();
            $table->time('sabtu_pulang')->nullable();

            // Kolom untuk hari Minggu
            $table->time('minggu_masuk')->nullable();
            $table->time('minggu_pulang')->nullable();

            // Foreign key constraint
            $table->foreign('shift_id')->references('id')->on('shifts')->onDelete('cascade');

            // Timestamps
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jam_kerjas');
    }
};
