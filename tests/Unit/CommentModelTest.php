<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\User;
use App\Models\Film;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_comment_can_be_created()
    {
        $comment = Comment::factory()->create();
        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'content' => $comment->content,
        ]);
    }

    public function test_comment_relationships()
    {
        $comment = Comment::factory()->create();
        $this->assertInstanceOf(User::class, $comment->user);
        $this->assertInstanceOf(Film::class, $comment->film);
    }
} 