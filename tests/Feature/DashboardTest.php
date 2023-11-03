<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Tests\TestCase;


class DashboardTest extends TestCase
{
    public function test_dashboard_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/dashboard');

        $response->assertOk();
    }

    public function test_dashboard_redirects_if_guest(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }
}
