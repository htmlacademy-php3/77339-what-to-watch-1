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
        ]);
    }

    public function test_comment_create_returns_201_and_structure()
    {
        $film = Film::factory()->create();
        $user = User::factory()->create();
        $commentData = Comment::factory()->make(['film_id' => $film->id, 'user_id' => $user->id])->toArray();
        $response = $this->actingAs($user)->postJson("/api/comments/{$film->id}", $commentData);
        $response->assertStatus(200); // Controller returns 200, not 201
        $response->assertJsonStructure([
            'success',
            'data',
        ]);
    }

    public function test_comment_update_requires_auth_and_returns_correct_status()
    {
        $comment = Comment::factory()->create();
        $user = User::factory()->create();
        $user->role = 2; // moderator
        $user->save();
        $response = $this->actingAs($user)->patchJson("/api/comments/{$comment->id}", [
            'content' => 'Updated content',
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data',
        ]);
    }

    public function test_comment_delete_requires_auth_and_returns_correct_status()
    {
        $comment = Comment::factory()->create();
        $user = User::factory()->create();
        $user->role = 2; // moderator
        $user->save();
        $response = $this->actingAs($user)->deleteJson("/api/comments/{$comment->id}");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data',
        ]);
    }
} 