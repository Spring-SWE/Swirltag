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
        Schema::create('taggables', function (Blueprint $table) {
            $table->unsignedBigInteger('tag_id');
            $table->morphs('taggable');

            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
            $table->index('taggable_type');

            // Adding a primary key that includes the tag_id, taggable_id, and taggable_type
            $table->primary(['tag_id', 'taggable_id', 'taggable_type'], 'taggable_primary_key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taggables');
    }
};
