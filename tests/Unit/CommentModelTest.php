<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\User;
use Faker\Factory;
use Faker\Generator;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentModelTest extends TestCase
{
    use RefreshDatabase;

    protected Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create('ru_RU');
    }

    /**
     * Проверяет, что у комментария есть специальное свойство для возврата имени автора
     */
    public function testAuthorName(): void
    {
        $user =
            User::factory()->create(['name' => 'Тестовый пользователь']);
        $userComment =
            Comment::factory()->for($user)->create();
        $guestComment =
            Comment::factory()->create(['user_id' => null]);

        $this->assertEquals('Тестовый пользователь', $userComment->getAuthorName());

        $this->assertEquals(Comment::DEFAULT_AUTHOR_NAME, $guestComment->getAuthorName());
    }
}
