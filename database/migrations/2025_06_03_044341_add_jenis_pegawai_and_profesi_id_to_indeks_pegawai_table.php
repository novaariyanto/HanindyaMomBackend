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
        Schema::table('indeks_pegawai', function (Blueprint $table) {
            $table->enum('jenis_pegawai', ['PNS', 'PPPK', 'KONTRAK', 'HONORER'])->nullable()->after('unit');
            $table->unsignedBigInteger('profesi_id')->nullable()->after('jenis_pegawai');
            
            // Index untuk foreign key
            $table->index('profesi_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('indeks_pegawai', function (Blueprint $table) {
            $table->dropIndex(['profesi_id']);
            $table->dropColumn(['jenis_pegawai', 'profesi_id']);
        });
    }
};
