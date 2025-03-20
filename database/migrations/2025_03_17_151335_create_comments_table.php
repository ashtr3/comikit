<?php

use App\Models\Comment;
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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->morphs('commentable');
            $table->foreignIdFor(Comment::class, 'parent_id')->nullable();
            $table->text('body');
            $table->unsignedInteger('patron_id');
            $table->string('patron_name');
            $table->string('patron_email');
            $table->string('patron_avatar');
            $table->boolean('is_creator');
            $table->boolean('has_pledged');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
