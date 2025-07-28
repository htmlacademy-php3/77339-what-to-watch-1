<?php

namespace Tests\Feature;

use App\Models\Genre;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GenreTest extends TestCase
{
    use RefreshDatabase;

    public function test_genre_list_returns_correct_structure_and_status()
    {
        Genre::factory()->count(3)->create();
        $user = User::factory()->create();
        $response = $this->actingAs($user)->getJson('/api/genres');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data',
        ]);
    }

    public function test_genre_update_requires_auth_and_returns_correct_status()
    {
        $genre = Genre::factory()->create();
        $user = User::factory()->create();
        $user->role = 2; // moderator
        $user->save();
        $response = $this->actingAs($user)->patchJson("/api/genres/{$genre->id}", [
            'name' => 'Updated Genre',
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data',
        ]);
    }
} 