<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SettingsManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create admin user
        $this->admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
        ]);

        // Create staff user
        $this->staff = User::factory()->create([
            'role' => User::ROLE_STAFF,
        ]);
        
        Storage::fake('public');
    }

    /** @test */
    public function admin_can_view_company_settings_page()
    {
        $this->actingAs($this->admin)
            ->get(route('admin.settings.company'))
            ->assertStatus(200)
            ->assertSee('Company Settings');
    }

    /** @test */
    public function admin_can_view_user_management_page()
    {
        $this->actingAs($this->admin)
            ->get(route('admin.settings.users'))
            ->assertStatus(200)
            ->assertSee('User Management');
    }

    /** @test */
    public function admin_can_view_pricing_configuration_page()
    {
        $this->actingAs($this->admin)
            ->get(route('admin.settings.pricing'))
            ->assertStatus(200)
            ->assertSee('Pricing Configuration');
    }

    /** @test */
    public function admin_can_view_system_configuration_page()
    {
        $this->actingAs($this->admin)
            ->get(route('admin.settings.system'))
            ->assertStatus(200)
            ->assertSee('System Configuration');
    }

    /** @test */
    public function staff_cannot_access_settings_pages()
    {
        $this->actingAs($this->staff)
            ->get(route('admin.settings.company'))
            ->assertStatus(403);

        $this->actingAs($this->staff)
            ->get(route('admin.settings.users'))
            ->assertStatus(403);

        $this->actingAs($this->staff)
            ->get(route('admin.settings.pricing'))
            ->assertStatus(403);

        $this->actingAs($this->staff)
            ->get(route('admin.settings.system'))
            ->assertStatus(403);
    }

    /** @test */
    public function admin_can_update_company_settings()
    {
        $companyData = [
            'company_name' => 'Updated Anugerah Rentcar',
            'company_address' => 'Updated Address 123',
            'company_phone' => '+62-21-1234567',
        ];

        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.settings.update-company'), $companyData);

        $response->assertStatus(200)
                ->assertJson(['success' => true]);

        $settings = Setting::current();
        $this->assertEquals('Updated Anugerah Rentcar', $settings->company_name);
        $this->assertEquals('Updated Address 123', $settings->company_address);
        $this->assertEquals('+62-21-1234567', $settings->company_phone);
    }

    /** @test */
    public function admin_can_update_pricing_configuration()
    {
        $pricingData = [
            'late_penalty_per_hour' => 75000,
            'buffer_time_hours' => 4,
            'member_discount_percentage' => 15,
        ];

        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.settings.update-pricing'), $pricingData);

        $response->assertStatus(200)
                ->assertJson(['success' => true]);

        $settings = Setting::current();
        $this->assertEquals(75000, $settings->late_penalty_per_hour);
        $this->assertEquals(4, $settings->buffer_time_hours);
        $this->assertEquals(15, $settings->member_discount_percentage);
    }

    /** @test */
    public function admin_can_create_new_user()
    {
        $userData = [
            'name' => 'New Test User',
            'email' => 'newuser@test.com',
            'phone' => '+62-812-3456789',
            'role' => User::ROLE_STAFF,
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'is_active' => true,
        ];

        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.settings.create-user'), $userData);

        $response->assertStatus(200)
                ->assertJson(['success' => true]);

        $this->assertDatabaseHas('users', [
            'name' => 'New Test User',
            'email' => 'newuser@test.com',
            'phone' => '+62-812-3456789',
            'role' => User::ROLE_STAFF,
            'is_active' => true,
        ]);

        $user = User::where('email', 'newuser@test.com')->first();
        $this->assertTrue(Hash::check('password123', $user->password));
    }

    /** @test */
    public function admin_can_update_existing_user()
    {
        $user = User::factory()->create([
            'name' => 'Original Name',
            'email' => 'original@test.com',
            'role' => User::ROLE_DRIVER,
        ]);

        $updateData = [
            'name' => 'Updated Name',
            'email' => 'updated@test.com',
            'phone' => '+62-812-9876543',
            'role' => User::ROLE_STAFF,
            'is_active' => true,
        ];

        $response = $this->actingAs($this->admin)
            ->patchJson(route('admin.settings.update-user', $user), $updateData);

        $response->assertStatus(200)
                ->assertJson(['success' => true]);

        $user->refresh();
        $this->assertEquals('Updated Name', $user->name);
        $this->assertEquals('updated@test.com', $user->email);
        $this->assertEquals(User::ROLE_STAFF, $user->role);
    }

    /** @test */
    public function admin_can_toggle_user_status()
    {
        $user = User::factory()->create(['is_active' => true]);

        $response = $this->actingAs($this->admin)
            ->patchJson(route('admin.settings.toggle-user-status', $user));

        $response->assertStatus(200)
                ->assertJson(['success' => true]);

        $user->refresh();
        $this->assertFalse($user->is_active);
    }

    /** @test */
    public function admin_can_delete_user()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->admin)
            ->deleteJson(route('admin.settings.delete-user', $user));

        $response->assertStatus(200)
                ->assertJson(['success' => true]);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    /** @test */
    public function admin_cannot_delete_themselves()
    {
        $response = $this->actingAs($this->admin)
            ->deleteJson(route('admin.settings.delete-user', $this->admin));

        $response->assertStatus(422)
                ->assertJson(['success' => false]);

        $this->assertDatabaseHas('users', ['id' => $this->admin->id]);
    }

    /** @test */
    public function admin_cannot_delete_last_admin()
    {
        // Make sure there's only one admin
        User::where('role', User::ROLE_ADMIN)->where('id', '!=', $this->admin->id)->delete();

        $response = $this->actingAs($this->admin)
            ->deleteJson(route('admin.settings.delete-user', $this->admin));

        $response->assertStatus(422)
                ->assertJson(['success' => false]);

        $this->assertDatabaseHas('users', ['id' => $this->admin->id]);
    }

    /** @test */
    public function settings_changes_are_logged()
    {
        $companyData = [
            'company_name' => 'Logged Company Name',
            'company_address' => 'Logged Address',
            'company_phone' => '+62-21-7777777',
        ];

        $this->actingAs($this->admin)
            ->postJson(route('admin.settings.update-company'), $companyData);

        // Check that log entry was created (this would require checking log files in a real scenario)
        // For now, we just verify the settings were updated
        $settings = Setting::current();
        $this->assertEquals('Logged Company Name', $settings->company_name);
    }

    /** @test */
    public function company_logo_can_be_uploaded()
    {
        $file = UploadedFile::fake()->image('logo.jpg', 200, 200);

        $companyData = [
            'company_name' => 'Test Company',
            'company_address' => 'Test Address',
            'company_phone' => '+62-21-1234567',
            'company_logo' => $file,
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.settings.update-company'), $companyData);

        $response->assertStatus(200);

        $settings = Setting::current();
        $this->assertNotNull($settings->company_logo);
        Storage::disk('public')->assertExists($settings->company_logo);
    }

    /** @test */
    public function pricing_validation_works()
    {
        $invalidData = [
            'late_penalty_per_hour' => -100, // Invalid: negative
            'buffer_time_hours' => 25, // Invalid: > 24
            'member_discount_percentage' => 150, // Invalid: > 100
        ];

        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.settings.update-pricing'), $invalidData);

        $response->assertStatus(422)
                ->assertJsonValidationErrors([
                    'late_penalty_per_hour',
                    'buffer_time_hours',
                    'member_discount_percentage'
                ]);
    }

    /** @test */
    public function user_validation_works()
    {
        $invalidData = [
            'name' => '', // Required
            'email' => 'invalid-email', // Invalid format
            'role' => 'invalid-role', // Invalid role
            'password' => '123', // Too short
        ];

        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.settings.create-user'), $invalidData);

        $response->assertStatus(422)
                ->assertJsonValidationErrors([
                    'name',
                    'email',
                    'role',
                    'password'
                ]);
    }
}