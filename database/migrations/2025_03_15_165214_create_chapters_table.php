<?php

use App\Models\Volume;
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
        Schema::create('chapters', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Volume::class, 'volume_id')->constrained()->onDelete('restrict');
            $table->unsignedInteger('chapter_index');
            $table->unsignedInteger('chapter_number')->nullable();
            $table->string('chapter_name')->nullable();
            $table->text('chapter_description')->nullable();
            $table->timestamps();

            $table->unique(['volume_id', 'chapter_number', 'chapter_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chapters');
    }
};
