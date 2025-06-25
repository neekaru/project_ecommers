<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->unsignedBigInteger('pesanan_id')->nullable()->after('customer_id');
            $table->foreign('pesanan_id')->references('id')->on('pesanans')->onDelete('cascade');
        });

        Schema::table('komentars', function (Blueprint $table) {
            $table->unsignedBigInteger('pesanan_id')->nullable()->after('customer_id');
            $table->foreign('pesanan_id')->references('id')->on('pesanans')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->dropForeign(['pesanan_id']);
            $table->dropColumn('pesanan_id');
        });

        Schema::table('komentars', function (Blueprint $table) {
            $table->dropForeign(['pesanan_id']);
            $table->dropColumn('pesanan_id');
        });
    }
};