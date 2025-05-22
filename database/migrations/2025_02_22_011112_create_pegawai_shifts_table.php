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
        Schema::create('pegawai_shifts', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->unsignedBigInteger('pegawai_id');
            $table->unsignedBigInteger('shift_id');
            $table->date('tanggal');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            
            $table->foreign('pegawai_id')->references('id')->on('pegawai_masters')->onDelete('cascade');
            $table->foreign('shift_id')->references('id')->on('shifts')->onDelete('cascade');


            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai_shifts');
    }
};
