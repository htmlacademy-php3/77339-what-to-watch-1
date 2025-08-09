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
            $table->string('name')->nullable();
            $table->string('status')->default('ready');
            $table->string('released')->nullable();
            $table->text('description')->nullable();
            $table->string('run_time')->nullable();
            $table->decimal('rating', 3, 1)->nullable();
            $table->integer('imdb_votes')->nullable();
            $table->string('imdb_id')->unique()->nullable();
            $table->string('poster_image')->nullable();
            $table->string('preview_image')->nullable();
            $table->string('background_image')->nullable();
            $table->string('background_color')->nullable();
            $table->string('video_link')->nullable();
            $table->string('preview_video_link')->nullable();
            $table->boolean('is_promo')->default(false)
                ->comment('Флаг промо-фильма');
            $table->timestamps();
        });

        Schema::table('films', function (Blueprint $table) {
            $table->index('is_promo');
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
