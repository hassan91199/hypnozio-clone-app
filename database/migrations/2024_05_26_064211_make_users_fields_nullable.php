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
        Schema::table('users', function (Blueprint $table) {
            // Make the specified columns nullable
            $table->string('name')->nullable()->change();
            $table->timestamp('email_verified_at')->nullable()->change();
            $table->string('password')->nullable()->change();
            $table->string('remember_token')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Revert the specified columns to be not nullable
            $table->string('name')->nullable(false)->change();
            $table->timestamp('email_verified_at')->nullable(false)->change();
            $table->string('password')->nullable(false)->change();
            $table->string('remember_token')->nullable(false)->change();
        });
    }
};
