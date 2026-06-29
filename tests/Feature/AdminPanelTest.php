<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_pages_render_for_authenticated_user(): void
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::query()->where('email', 'admin@escolafps.local')->firstOrFail();

        $this->actingAs($user);

        foreach ([
            '/admin',
            '/admin/students',
            '/admin/books',
            '/admin/categories',
            '/admin/loans',
            '/admin/users',
            '/admin/active-sessions',
            '/admin/email-logs',
        ] as $path) {
            $this->get($path)->assertOk();
        }
    }
}
