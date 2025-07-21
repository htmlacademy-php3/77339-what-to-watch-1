<?php

namespace Tests\Unit;

use App\Models\Film;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilmModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_film_can_be_created()
    {
        $film = Film::factory()->create();
        $this->assertDatabaseHas('films', [
            'id' => $film->id,
            'title' => $film->title,
        ]);
    }

    public function test_film_has_comments()
    {
        $film = Film::factory()->create();
        $comment = Comment::factory()->create(['film_id' => $film->id]);
        $this->assertTrue($film->comments->contains($comment));
    }
} 