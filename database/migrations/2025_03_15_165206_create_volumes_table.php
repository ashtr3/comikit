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
        Schema::create('volumes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('volume_index');
            $table->unsignedInteger('volume_number')->nullable();
            $table->string('volume_name')->nullable();
            $table->text('volume_description')->nullable();
            $table->timestamps();

            $table->unique(['volume_number', 'volume_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volumes');
    }
};
