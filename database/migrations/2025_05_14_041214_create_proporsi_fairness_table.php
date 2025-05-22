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
        Schema::create('proporsi_fairness', function (Blueprint $table) {
            $table->id();
            $table->string('groups', 50);
            $table->string('jenis', 50);
            $table->string('grade', 50);
            $table->string('ppa', 50);
            $table->decimal('value', 10, 2);
            $table->string('sumber', 100);
            $table->string('flag', 50);
            $table->boolean('del')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proporsi_fairness');
    }
};
