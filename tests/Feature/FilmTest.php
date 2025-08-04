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
            'timestamp'
        ]);
        $response->assertJson([
            'success' => true
        ]);
    }

    public function test_film_list_requires_authentication()
    {
        $response = $this->getJson('/api/films');
        
        $response->assertStatus(401);
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
            'timestamp'
        ]);
        $response->assertJson([
            'success' => true
        ]);
    }

    public function test_film_show_returns_404_for_nonexistent_film()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->getJson("/api/films/999");
        
        $response->assertStatus(404);
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
            'timestamp'
        ]);
        $response->assertJson([
            'success' => true
        ]);
    }

    public function test_film_create_requires_authentication()
    {
        $filmData = Film::factory()->make()->toArray();
        
        $response = $this->postJson('/api/films', $filmData);
        
        $response->assertStatus(401);
    }

    public function test_film_create_validates_required_fields()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->postJson('/api/films', []);
        
        $response->assertStatus(422);
    }

    public function test_film_update_requires_moderator_role()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create(['role' => User::ROLE_USER]);
        
        $response = $this->actingAs($user)->patchJson("/api/films/{$film->id}", [
            'title' => 'Updated Title',
        ]);
        
        $response->assertStatus(403);
    }

    public function test_film_update_requires_auth_and_returns_correct_status()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create(['role' => User::ROLE_MODERATOR]);
        
        $response = $this->actingAs($user)->patchJson("/api/films/{$film->id}", [
            'title' => 'Updated Title',
        ]);
        
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data',
            'timestamp'
        ]);
        $response->assertJson([
            'success' => true
        ]);
    }

    public function test_film_update_returns_404_for_nonexistent_film()
    {
        $user = User::factory()->create(['role' => User::ROLE_MODERATOR]);
        
        $response = $this->actingAs($user)->patchJson("/api/films/999", [
            'title' => 'Updated Title',
        ]);
        
        $response->assertStatus(404);
    }

    public function test_film_delete_requires_moderator_role()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create(['role' => User::ROLE_USER]);
        
        $response = $this->actingAs($user)->deleteJson("/api/films/{$film->id}");
        
        $response->assertStatus(403);
    }

    public function test_film_delete_requires_auth_and_returns_correct_status()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create(['role' => User::ROLE_MODERATOR]);
        
        $response = $this->actingAs($user)->deleteJson("/api/films/{$film->id}");
        
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data',
            'timestamp'
        ]);
        $response->assertJson([
            'success' => true
        ]);
    }

    public function test_film_delete_returns_404_for_nonexistent_film()
    {
        $user = User::factory()->create(['role' => User::ROLE_MODERATOR]);
        
        $response = $this->actingAs($user)->deleteJson("/api/films/999");
        
        $response->assertStatus(404);
    }

    public function test_film_similar_returns_correct_structure()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->getJson("/api/films/{$film->id}/similar");
        
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data',
            'timestamp'
        ]);
        $response->assertJson([
            'success' => true
        ]);
    }

    public function test_film_promo_returns_correct_structure()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->getJson("/api/promo");
        
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data',
            'timestamp'
        ]);
        $response->assertJson([
            'success' => true
        ]);
    }
} 