<?php

namespace Tests\Feature\User;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UnauthorizedUserDashboardTest extends TestCase
{
    /** @dataProvider urlProvider */
    public function test_unauthorized_can_not_enter_dashboard(string $url): void
    {
        $response = $this->get($url);

        $response->assertRedirect('/login');
    }

    private function urlProvider(): array
    {
        return [
            ['/user/account'],
            ['/user/posts'],
            ['/user/posts/create'],
            ['/user/comments'],
            ['/user/security'],
            ['/user/newsletter'],
        ];
    }

    public function test_new_post_can_not_be_created_by_unauthorized_user(): void
    {
        $response = $this->postJson('/user/posts', [
            'title' => 'Title',
            'slug' => 'Slug',
            'thumbnail' => new UploadedFile(
                public_path('storage/public/logo.png'),
                'logo.png',
                null,
                null,
                true
            ),
            'excerpt' => 'Excerpt',
            'body' => 'Body',
            'category_id' => 1,
        ]);

        $response->assertStatus(401);
    }
}
