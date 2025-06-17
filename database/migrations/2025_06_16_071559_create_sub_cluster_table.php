<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubClusterTable extends Migration
{
    public function up(): void
    {
        Schema::create('sub_cluster', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ppa', 100);
            $table->decimal('nominal', 18, 2)->default(0);
            $table->unsignedBigInteger('remunerasi_source')->nullable();
            $table->unsignedInteger('cluster')->default(0);
            $table->timestamps();

            // Optional: Tambahkan FK jika ada tabel 'remunerasi_source'
            // $table->foreign('remunerasi_source')->references('id')->on('remunerasi_sources');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_cluster');
    }
}
