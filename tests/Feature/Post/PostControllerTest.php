<?php

namespace Tests\Feature\Post;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    private array $posts;
    private int $amountOfPosts = 10;

    private function preparePosts(): void
    {
        for ($i = 0; $i < $this->amountOfPosts; ++$i) {
            $this->posts[] = Post::factory()->create();
        }
    }

    public function test_paige_without_posts_can_be_rendered(): void
    {
        $response = $this->get('/');

        $response->assertSee('No posts yet. Please check back later.');
    }

    public function test_paige_with_all_posts_can_be_rendered(): void
    {
        $this->preparePosts();
        $response = $this->get('/');

        $response->assertSee(array_map(static fn (Post $post) => $post->title, $this->posts));
    }
}
