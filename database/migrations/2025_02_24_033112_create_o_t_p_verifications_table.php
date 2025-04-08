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
        Schema::create('o_t_p_verifications', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('nomor_hp')->unique(); // Nomor HP pengguna (unik)
            $table->string('otp_code'); // Kode OTP (6 karakter atau lebih)
            $table->timestamp('expires_at'); // Waktu kedaluwarsa OTP
            $table->timestamps(); // Kolom created_at dan updated_at
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('o_t_p_verifications');
    }
};
