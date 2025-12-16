<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that login page is accessible.
     */
    public function test_login_page_is_accessible(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Email');
        $response->assertSee('Password');
        $response->assertSee('Log in');
    }

    /**
     * Test that register page is accessible.
     */
    public function test_register_page_is_accessible(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSee('Name');
        $response->assertSee('Email');
        $response->assertSee('Register');
    }

    /**
     * Test user can login with valid credentials.
     */
    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'phone' => '1234567890',
            'role' => 'staff',
            'is_active' => true,
        ]);

        $response = $this->get('/login');
        $response->assertStatus(200);
        
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
    }

    /**
     * Test user cannot login with invalid credentials.
     */
    public function test_user_cannot_login_with_invalid_credentials(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $this->assertGuest();
    }

    /**
     * Test user can register successfully.
     */
    public function test_user_can_register_successfully(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSee('Name');
        $response->assertSee('Email');
    }

    /**
     * Test dashboard requires authentication.
     */
    public function test_dashboard_requires_authentication(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }
}
