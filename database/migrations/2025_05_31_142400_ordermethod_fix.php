<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_methods', function (Blueprint $table) {
            // Membuat kolom checkout_id bisa bernilai null
            $table->unsignedBigInteger('checkout_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('order_methods', function (Blueprint $table) {
            // Mengembalikan kolom checkout_id menjadi tidak nullable
            $table->unsignedBigInteger('checkout_id')->nullable(false)->change();
        });
    }
};
