<?php

use App\Models\Chapter;
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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Chapter::class, 'chapter_id')->constrained()->onDelete('restrict');
            $table->unsignedInteger('page_index');
            $table->unsignedInteger('page_number')->nullable();
            $table->string('page_name')->nullable();
            $table->string('page_image')->nullable();
            $table->text('page_description')->nullable();
            $table->text('page_secret')->nullable();
            $table->boolean('is_cover')->default(false);
            $table->boolean('is_special')->default(false);
            $table->timestamp('patreon_release_at');
            $table->timestamp('public_release_at');
            $table->timestamps();

            $table->unique(['chapter_id', 'page_number', 'page_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
