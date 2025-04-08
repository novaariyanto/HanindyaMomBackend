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
        Schema::create('radius', function (Blueprint $table) {
            $table->id();
            $table->text('coordinates'); // JSON array untuk koordinat
            $table->decimal('width', 10, 2); // Lebar kotak
            $table->decimal('height', 10, 2); // Tinggi kotak
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('radius');
    }
};
