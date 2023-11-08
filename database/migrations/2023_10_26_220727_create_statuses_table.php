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
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('body')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->boolean('is_edited')->default(0);
            $table->bigInteger('parent_id')->nullable();
            $table->bigInteger('upvote_count')->default(0);
            $table->bigInteger('downvote_count')->default(0);
            $table->bigInteger('reply_count')->default(0);
            $table->bigInteger('view_count')->default(0);
            $table->bigInteger('repost_count')->default(0);
            $table->bigInteger('share_count')->default(0);
            $table->bigInteger('deboost_score')->default(0);
            $table->boolean("is_archived")->default(0);
            $table->boolean('is_flagged')->default(0);
            $table->json('metadata')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statues');
    }
};
