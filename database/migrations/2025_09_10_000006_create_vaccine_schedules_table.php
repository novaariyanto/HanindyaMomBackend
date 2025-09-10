<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vaccine_schedules', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('baby_id', 36);
            $table->string('vaccine_name', 150);
            $table->date('schedule_date');
            $table->enum('status', ['scheduled','done'])->default('scheduled');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vaccine_schedules');
    }
};


