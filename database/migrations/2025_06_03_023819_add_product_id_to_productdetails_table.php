<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('productdetails', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->after('id'); // tambahkan kolom
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade'); // foreign key
        });
    }

    public function down(): void
    {
        Schema::table('productdetails', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropColumn('product_id');
        });
    }
};

