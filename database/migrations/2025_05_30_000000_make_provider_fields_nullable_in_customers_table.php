<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('provider_id')->nullable()->change();
            $table->string('provider_name')->nullable()->change();
            $table->string('avatar')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('provider_id')->nullable(false)->change();
            $table->string('provider_name')->nullable(false)->change();
            $table->string('avatar')->nullable(false)->change();
        });
    }
}; 