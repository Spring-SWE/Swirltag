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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('media_type', 50);
            $table->string('file_name', 255);
            $table->string('file_path', 255);
            $table->integer('file_size');
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->string('format', 50)->nullable();
            $table->integer('duration')->nullable(); // in seconds
            $table->string('thumbnail_path', 255)->nullable();
            $table->string('alt_text', 255)->nullable();
            $table->enum('status', ['active', 'deleted', 'reported'])->default('active');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
