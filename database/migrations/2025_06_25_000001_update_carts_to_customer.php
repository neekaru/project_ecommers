<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            // Drop user_id foreign key and column if exists
            if (Schema::hasColumn('carts', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
            // Drop existing customer_id foreign key if exists to avoid duplicate error
            try {
                $table->dropForeign(['customer_id']);
            } catch (\Throwable $e) {
                // Ignore if not exists
            }
            // Ensure customer_id exists and add foreign key
            if (!Schema::hasColumn('carts', 'customer_id')) {
                $table->unsignedBigInteger('customer_id')->nullable()->after('id');
            }
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
            $table->dropColumn('customer_id');
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }
};