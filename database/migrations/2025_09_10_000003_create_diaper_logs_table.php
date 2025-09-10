<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diaper_logs', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('baby_id', 36);
            $table->enum('type', ['pipis','pup','campuran']);
            $table->string('color', 50)->nullable();
            $table->string('texture', 50)->nullable();
            $table->dateTime('time');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diaper_logs');
    }
};


