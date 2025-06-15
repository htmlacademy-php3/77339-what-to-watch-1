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
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('year')->nullable();
            $table->string('description')->nullable();
            $table->string('director')->nullable();
            $table->text('actors')->nullable();
            $table->string('duration')->nullable();
            $table->decimal('imdb_rating', 3, 1)->nullable();
            $table->integer('imdb_votes')->nullable();
            $table->string('imdb_id')->unique()->nullable();
            $table->string('poster_url')->nullable();
            $table->string('preview_url')->nullable();
            $table->string('background_color')->nullable();
            $table->string('cover_url')->nullable();
            $table->string('video_url')->nullable();
            $table->string('video_preview_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('films');
    }
};
