<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('baby_profiles', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('user_uuid', 36);
            $table->string('name', 100);
            $table->date('birth_date');
            $table->string('photo', 255)->nullable();
            $table->decimal('birth_weight', 5, 2)->nullable();
            $table->decimal('birth_height', 5, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('baby_profiles');
    }
};


