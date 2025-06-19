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
        Schema::table('varian_products', function (Blueprint $table) {
            $table->decimal('price', 10, 2)
                  ->after('nama_varian')
                  ->default(0.00)
                  ->comment('Harga spesifik untuk setiap varian produk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('varian_products', function (Blueprint $table) {
            $table->dropColumn('price');
        });
    }
};
