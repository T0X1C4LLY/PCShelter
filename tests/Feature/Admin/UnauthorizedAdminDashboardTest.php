<?php

declare(strict_types=1);

namespace Tests\Feature\Admin;

use Tests\TestCase;

class UnauthorizedAdminDashboardTest extends TestCase
{
    /** @dataProvider urlProvider */
    public function test_admin_dashboard_screen_can_not_be_rendered_while_unauthenticated(string $url): void
    {
        $response = $this->get($url);

        $response->assertStatus(403);
    }

    private function urlProvider(): array
    {
        return [
            ['/admin/posts'],
            ['/admin/users']
        ];
    }
}
