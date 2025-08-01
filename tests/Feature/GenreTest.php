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
        // Create test data
        Genre::factory()->count(3)->create();
        $user = User::factory()->create();
        
        // Make request
        $response = $this->actingAs($user)->getJson('/api/genres');
        
        // Assert response
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

    public function test_genre_list_requires_authentication()
    {
        // Make request without authentication
        $response = $this->getJson('/api/genres');
        
        // Assert response
        $response->assertStatus(401);
    }

    public function test_genre_update_requires_moderator_role()
    {
        $genre = Genre::factory()->create();
        $user = User::factory()->create(['role' => User::ROLE_USER]);
        
        $response = $this->actingAs($user)->patchJson("/api/genres/{$genre->id}", [
            'name' => 'Updated Genre',
        ]);
        
        $response->assertStatus(403);
    }

    public function test_genre_update_requires_auth_and_returns_correct_status()
    {
        $genre = Genre::factory()->create();
        $user = User::factory()->create(['role' => User::ROLE_MODERATOR]);
        
        $response = $this->actingAs($user)->patchJson("/api/genres/{$genre->id}", [
            'name' => 'Updated Genre',
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

    public function test_genre_update_returns_404_for_nonexistent_genre()
    {
        $user = User::factory()->create(['role' => User::ROLE_MODERATOR]);
        
        $response = $this->actingAs($user)->patchJson("/api/genres/999", [
            'name' => 'Updated Genre',
        ]);
        
        $response->assertStatus(404);
    }

    public function test_genre_update_validates_input()
    {
        $genre = Genre::factory()->create();
        $user = User::factory()->create(['role' => User::ROLE_MODERATOR]);
        
        $response = $this->actingAs($user)->patchJson("/api/genres/{$genre->id}", [
            'name' => '', // Empty name should be invalid
        ]);
        
        $response->assertStatus(422);
    }
} 