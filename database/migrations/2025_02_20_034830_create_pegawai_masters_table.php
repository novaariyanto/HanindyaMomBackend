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
        Schema::create('pegawai_masters', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('nik',16);

            $table->string('nama');
            $table->integer('jabatan_id');
            $table->integer('divisi_id');
            $table->enum('status',['aktif','non_aktif']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai_masters');
    }
};
