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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->unsignedBigInteger('post_count')->default(0);
            $table->integer('role')->default(0);
            $table->string('avatar')->nullable();
            $table->string('cover')->nullable();
            $table->string('description')->nullable();
            $table->string('website')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->integer('is_banned')->default(0);
            $table->integer('is_active')->default(1);
            $table->integer('is_verified')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
