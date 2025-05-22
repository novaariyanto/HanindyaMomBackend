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
        Schema::create('presensis', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->foreignId('pegawai_id')->constrained('pegawai_masters')->onDelete('cascade'); // Relasi ke pegawai
            $table->foreignId('pegawai_shift_id')->nullable()->constrained('pegawai_shifts')->onDelete('set null'); // Relasi ke pegawai_shift
            $table->date('tanggal'); // Tanggal presensi
            $table->time('jam_masuk')->nullable(); // Jam masuk aktual
            $table->time('jam_keluar')->nullable(); // Jam keluar aktual
            $table->time('jam_masuk_jadwal')->nullable(); // Jam masuk sesuai jadwal
            $table->time('jam_keluar_jadwal')->nullable(); // Jam keluar sesuai jadwal
            $table->enum('status', ['hadir', 'terlambat', 'izin', 'sakit', 'alpha']); // Status presensi
            $table->text('keterangan')->nullable(); // Keterangan tambahan (opsional)
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null'); // Siapa yang membuat
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null'); // Siapa yang memperbarui
            $table->timestamps(); // Kolom created_at dan updated_at

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensis');
    }
};
