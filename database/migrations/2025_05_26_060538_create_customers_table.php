<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('email')->unique(); // email tidak nullable untuk login
            $table->string('telepon', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->string('password'); // kolom password penting untuk login
            $table->rememberToken(); // untuk fitur "remember me"
            $table->timestamp('email_verified_at')->nullable(); // opsional untuk verifikasi email
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
}
