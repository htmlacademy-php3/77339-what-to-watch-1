<?php

namespace Tests\Feature;

use App\Models\Film;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilmTest extends TestCase
{
    use RefreshDatabase;

    public function test_film_list_returns_correct_structure_and_status()
    {
        Film::factory()->count(3)->create();
        $user = User::factory()->create();
        $response = $this->actingAs($user)->getJson('/api/films');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data',
        ]);
    }

    public function test_film_show_returns_correct_structure_and_status()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create();
        $response = $this->actingAs($user)->getJson("/api/films/{$film->id}");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data',
        ]);
    }

    public function test_film_create_returns_201_and_structure()
    {
        $user = User::factory()->create();
        $filmData = Film::factory()->make()->toArray();
        $response = $this->actingAs($user)->postJson('/api/films', $filmData);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'success',
            'data',
        ]);
    }

    public function test_film_update_requires_auth_and_returns_correct_status()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create();
        $user->role = 2; // moderator
        $user->save();
        $response = $this->actingAs($user)->patchJson("/api/films/{$film->id}", [
            'title' => 'Updated Title',
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data',
        ]);
    }

    public function test_film_delete_requires_auth_and_returns_correct_status()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create();
        $user->role = 2; // moderator
        $user->save();
        $response = $this->actingAs($user)->deleteJson("/api/films/{$film->id}");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data',
        ]);
    }
} 