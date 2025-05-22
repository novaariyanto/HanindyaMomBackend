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
        Schema::create('user_divisis', function (Blueprint $table) {
 // Kolom untuk user_id dan divisi_id
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('divisi_id');

            // Primary key gabungan
            $table->primary(['user_id', 'divisi_id']);

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('divisi_id')->references('id')->on('divisis')->onDelete('cascade');

            // Timestamps (opsional)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_divisis');
    }
};
