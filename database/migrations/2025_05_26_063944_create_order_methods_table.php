<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderMethodsTable extends Migration
{
    public function up(): void
    {
        Schema::create('order_methods', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('checkout_id');
            $table->string('metode_pesanan');
            $table->boolean('dijadwalkan')->default(false);
            $table->date('tanggal_pengambilan')->nullable();
            $table->time('waktu_pengambilan')->nullable();
            $table->timestamps();

            $table->foreign('checkout_id')->references('id')->on('checkouts')->onDelete('cascade');
            $table->index('checkout_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_methods');
    }
}
