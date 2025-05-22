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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('website_name')->nullable(); // Nama website
            $table->text('website_description')->nullable(); // Deskripsi website
            $table->string('logo')->nullable(); // Path atau URL logo
            $table->string('favicon')->nullable(); // Path atau URL favicon
            $table->string('email')->nullable(); // Email kontak
            $table->string('phone')->nullable(); // Nomor telepon
            $table->text('address')->nullable(); // Alamat
            $table->timestamps(); // created_at dan updated_at

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
