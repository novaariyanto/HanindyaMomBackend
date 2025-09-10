<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feeding_logs', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('baby_id', 36);
            $table->enum('type', ['asi_left','asi_right','formula','pump']);
            $table->dateTime('start_time');
            $table->integer('duration_minutes');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feeding_logs');
    }
};


