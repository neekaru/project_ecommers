<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('cart_addons', function (Blueprint $table) {
            // 1. Jika foreign key lama ada, drop dulu
            if (Schema::hasColumn('cart_addons', 'product_addon_id')) {
                // Nama FK default Laravel: cart_addons_product_addon_id_foreign
                $table->dropForeign('cart_addons_product_addon_id_foreign');
            }

            // 2. Drop kolom duplikat
            if (Schema::hasColumn('cart_addons', 'name')) {
                $table->dropColumn('name');
            }
            if (Schema::hasColumn('cart_addons', 'price')) {
                $table->dropColumn('price');
            }

            // 3. (Re)declare FK jika perlu — tapi biasanya tidak perlu jika sudah terdefinisi
            // $table->foreign('product_addon_id')
            //       ->references('id')->on('product_addons')
            //       ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('cart_addons', function (Blueprint $table) {
            // 1. Kembalikan kolom name & price
            $table->string('name')->after('product_addon_id');
            $table->decimal('price', 10, 2)->after('name');

            // 2. Kembalikan FK jika sebelumnya di-drop
            $table->foreign('product_addon_id')
                  ->references('id')->on('product_addons')
                  ->onDelete('cascade');
        });
    }
};

