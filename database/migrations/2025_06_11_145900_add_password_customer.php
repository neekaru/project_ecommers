<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            if (!Schema::hasColumn('customers', 'password')) {
            $table->string('password'); // kolom password penting untuk login
            }

            if (!Schema::hasColumn('customers', 'remember_token')) {
            $table->rememberToken(); // untuk fitur "remember me"
            }

            if (!Schema::hasColumn('customers', 'email_verified_at')) {
            $table->timestamp('email_verified_at')->nullable(); // opsional untuk verifikasi email
            }

            if (!Schema::hasColumn('customers', 'created_at') || !Schema::hasColumn('customers', 'updated_at')) {
            $table->timestamps();
            }
        });
    }

    public function down(): void
    {
        // Drop foreign key in checkouts before dropping customers
        if (Schema::hasTable('checkouts')) {
            Schema::table('checkouts', function (Blueprint $table) {
                if (Schema::hasColumn('checkouts', 'customer_id')) {
                    try {
                        $table->dropForeign(['customer_id']);
                    } catch (\Exception $e) {}
                }
            });
        }
        // Drop foreign key in komentars before dropping customers
        if (Schema::hasTable('komentars')) {
            Schema::table('komentars', function (Blueprint $table) {
                if (Schema::hasColumn('komentars', 'customer_id')) {
                    try {
                        $table->dropForeign(['customer_id']);
                    } catch (\Exception $e) {}
                }
            });
        }
        Schema::dropIfExists('customers');
    }
};
