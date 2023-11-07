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
        Schema::create('mediables', function (Blueprint $table) {
            $table->unsignedBigInteger('media_id');
            $table->morphs('mediable');
            $table->integer('order')->nullable();
            $table->timestamps();

            $table->foreign('media_id')->references('id')->on('media')->onDelete('cascade');

            // Adding a primary key that includes the media_id, mediable_id, and mediable_type.
            $table->primary(['media_id', 'mediable_id', 'mediable_type'], 'mediables_primary_key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mediables');
    }
};
