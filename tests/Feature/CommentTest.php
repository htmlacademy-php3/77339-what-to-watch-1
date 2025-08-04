<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Film;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_comment_list_returns_correct_structure_and_status()
    {
        $film = Film::factory()->create();
        Comment::factory()->count(3)->create(['film_id' => $film->id]);
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->getJson("/api/comments/{$film->id}");
        
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

    public function test_comment_list_requires_authentication()
    {
        $film = Film::factory()->create();
        
        $response = $this->getJson("/api/comments/{$film->id}");
        
        $response->assertStatus(401);
    }

    public function test_comment_list_returns_404_for_nonexistent_film()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->getJson("/api/comments/999");
        
        $response->assertStatus(404);
    }

    public function test_comment_create_returns_correct_structure()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create();
        $commentData = Comment::factory()->make([
            'film_id' => $film->id, 
            'user_id' => $user->id
        ])->toArray();
        
        $response = $this->actingAs($user)->postJson("/api/comments/{$film->id}", $commentData);
        
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

    public function test_comment_create_requires_authentication()
    {
        $film = Film::factory()->create();
        $commentData = Comment::factory()->make()->toArray();
        
        $response = $this->postJson("/api/comments/{$film->id}", $commentData);
        
        $response->assertStatus(401);
    }

    public function test_comment_create_returns_404_for_nonexistent_film()
    {
        $user = User::factory()->create();
        $commentData = Comment::factory()->make()->toArray();
        
        $response = $this->actingAs($user)->postJson("/api/comments/999", $commentData);
        
        $response->assertStatus(404);
    }

    public function test_comment_create_validates_required_fields()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->postJson("/api/comments/{$film->id}", []);
        
        $response->assertStatus(422);
    }

    public function test_comment_update_requires_moderator_role()
    {
        $comment = Comment::factory()->create();
        $user = User::factory()->create(['role' => User::ROLE_USER]);
        
        $response = $this->actingAs($user)->patchJson("/api/comments/{$comment->id}", [
            'content' => 'Updated content',
        ]);
        
        $response->assertStatus(403);
    }

    public function test_comment_update_requires_auth_and_returns_correct_status()
    {
        $comment = Comment::factory()->create();
        $user = User::factory()->create(['role' => User::ROLE_MODERATOR]);
        
        $response = $this->actingAs($user)->patchJson("/api/comments/{$comment->id}", [
            'content' => 'Updated content',
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

    public function test_comment_update_returns_404_for_nonexistent_comment()
    {
        $user = User::factory()->create(['role' => User::ROLE_MODERATOR]);
        
        $response = $this->actingAs($user)->patchJson("/api/comments/999", [
            'content' => 'Updated content',
        ]);
        
        $response->assertStatus(404);
    }

    public function test_comment_update_validates_input()
    {
        $comment = Comment::factory()->create();
        $user = User::factory()->create(['role' => User::ROLE_MODERATOR]);
        
        $response = $this->actingAs($user)->patchJson("/api/comments/{$comment->id}", [
            'content' => '',
        ]);
        
        $response->assertStatus(422);
    }

    public function test_comment_delete_requires_moderator_role()
    {
        $comment = Comment::factory()->create();
        $user = User::factory()->create(['role' => User::ROLE_USER]);
        
        $response = $this->actingAs($user)->deleteJson("/api/comments/{$comment->id}");
        
        $response->assertStatus(403);
    }

    public function test_comment_delete_requires_auth_and_returns_correct_status()
    {
        $comment = Comment::factory()->create();
        $user = User::factory()->create(['role' => User::ROLE_MODERATOR]);
        
        $response = $this->actingAs($user)->deleteJson("/api/comments/{$comment->id}");
        
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

    public function test_comment_delete_returns_404_for_nonexistent_comment()
    {
        $user = User::factory()->create(['role' => User::ROLE_MODERATOR]);
        
        $response = $this->actingAs($user)->deleteJson("/api/comments/999");
        
        $response->assertStatus(404);
    }

    public function test_comment_with_nested_comments()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create();
        
        $parentComment = Comment::factory()->create([
            'film_id' => $film->id,
            'user_id' => $user->id,
            'comment_id' => null
        ]);
        
        $childComment = Comment::factory()->create([
            'film_id' => $film->id,
            'user_id' => $user->id,
            'comment_id' => $parentComment->id
        ]);
        
        $response = $this->actingAs($user)->getJson("/api/comments/{$film->id}");
        
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data',
            'timestamp'
        ]);
    }

    public function test_comment_with_rating()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create();
        
        $commentData = Comment::factory()->make([
            'film_id' => $film->id,
            'user_id' => $user->id,
            'rate' => 8
        ])->toArray();
        
        $response = $this->actingAs($user)->postJson("/api/comments/{$film->id}", $commentData);
        
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data',
            'timestamp'
        ]);
    }
} 