<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings_apps', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('user_uuid', 36);
            $table->string('timezone', 100);
            $table->enum('unit', ['ml','oz'])->default('ml');
            $table->boolean('notifications')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings_apps');
    }
};


