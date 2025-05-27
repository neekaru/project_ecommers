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
        Schema::create('product_addons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id'); // FK ke produk utama
            $table->string('name', 100);              // nama add-on, misal: 'Extra Cheese'
            $table->decimal('price', 10, 2)->default(0); // harga tambahan
            $table->text('description')->nullable(); // deskripsi opsional
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_addons');
    }
};
