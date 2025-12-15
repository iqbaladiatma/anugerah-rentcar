<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminLayoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_loads_with_admin_layout(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_ADMIN,
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Anugerah Rentcar');
        $response->assertSee('Admin Panel');
        $response->assertSee('Dashboard');
    }

    public function test_admin_sidebar_shows_role_based_navigation(): void
    {
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->get('/dashboard');

        $response->assertStatus(200);
        // Admin should see all menu items
        $response->assertSee('Fleet Management');
        $response->assertSee('Customer Management');
        $response->assertSee('Booking Management');
        $response->assertSee('Financial Management');
        $response->assertSee('System Settings');
    }

    public function test_staff_user_has_limited_navigation(): void
    {
        $staff = User::factory()->create([
            'role' => User::ROLE_STAFF,
            'is_active' => true,
        ]);

        $response = $this->actingAs($staff)->get('/dashboard');

        $response->assertStatus(200);
        // Staff should see most menu items but not system settings
        $response->assertSee('Fleet Management');
        $response->assertSee('Customer Management');
        $response->assertSee('Booking Management');
        $response->assertSee('Financial Management');
        $response->assertDontSee('System Settings');
    }

    public function test_driver_user_has_minimal_navigation(): void
    {
        $driver = User::factory()->create([
            'role' => User::ROLE_DRIVER,
            'is_active' => true,
        ]);

        $response = $this->actingAs($driver)->get('/dashboard');

        $response->assertStatus(200);
        // Driver should only see dashboard
        $response->assertSee('Dashboard');
        $response->assertDontSee('Fleet Management');
        $response->assertDontSee('Customer Management');
        $response->assertDontSee('System Settings');
    }
}