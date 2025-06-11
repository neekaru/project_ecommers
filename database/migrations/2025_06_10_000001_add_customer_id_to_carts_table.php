<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah foreign key user_id pada tabel carts agar bisa nullable dan support ke tabel customers
        Schema::table('carts', function (Blueprint $table) {
            // Drop existing foreign key
            $table->dropForeign(['user_id']);
            // Jadikan user_id nullable
            $table->unsignedBigInteger('user_id')->nullable()->change();
            // Tambahkan kolom customer_id
            $table->unsignedBigInteger('customer_id')->nullable()->after('user_id');
            // Foreign key ke users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            // Foreign key ke customers
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['customer_id']);
            $table->dropColumn('customer_id');
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }
};
