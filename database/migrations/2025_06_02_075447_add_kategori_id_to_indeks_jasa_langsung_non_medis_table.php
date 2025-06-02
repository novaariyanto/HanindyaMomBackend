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
        Schema::table('indeks_jasa_langsung_non_medis', function (Blueprint $table) {
            // Menambahkan kolom kategori_id
            $table->unsignedBigInteger('kategori_id')->nullable()->after('nilai');
            $table->boolean('status')->default(true)->after('kategori_id');
            $table->softDeletes()->after('updated_at');
            
            // Menambahkan foreign key constraint
            $table->foreign('kategori_id')
                  ->references('id')
                  ->on('kategori_indeks_jasa_langsung_non_medis')
                  ->onDelete('set null');
                  
            // Menambahkan index
            $table->index('kategori_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('indeks_jasa_langsung_non_medis', function (Blueprint $table) {
            // Drop foreign key terlebih dahulu
            $table->dropForeign(['kategori_id']);
            
            // Drop indexes
            $table->dropIndex(['kategori_id']);
            $table->dropIndex(['status']);
            
            // Drop columns
            $table->dropColumn(['kategori_id', 'status']);
            $table->dropSoftDeletes();
        });
    }
};
