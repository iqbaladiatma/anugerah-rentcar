<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CustomerManagementTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create admin user
        $this->admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin@test.com'
        ]);
    }

    /** @test */
    public function admin_can_view_customer_index_page()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.customers.index'));

        $response->assertStatus(200);
        $response->assertSee('Customer Management');
    }

    /** @test */
    public function admin_can_view_customer_create_page()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.customers.create'));

        $response->assertStatus(200);
        $response->assertSee('Add New Customer');
    }

    /** @test */
    public function admin_can_create_customer()
    {
        Storage::fake('public');

        $ktpFile = UploadedFile::fake()->image('ktp.jpg');
        $simFile = UploadedFile::fake()->image('sim.jpg');

        $customerData = [
            'name' => 'John Doe',
            'phone' => '081234567890',
            'email' => 'john@example.com',
            'nik' => '1234567890123456',
            'address' => '123 Main Street, Jakarta',
            'ktp_photo' => $ktpFile,
            'sim_photo' => $simFile,
            'is_member' => true,
            'member_discount' => 15.0,
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.customers.store'), $customerData);

        $this->assertDatabaseHas('customers', [
            'name' => 'John Doe',
            'phone' => '081234567890',
            'email' => 'john@example.com',
            'nik' => '1234567890123456',
            'is_member' => true,
            'member_discount' => 15.0,
        ]);

        $customer = Customer::where('nik', '1234567890123456')->first();
        $response->assertRedirect(route('admin.customers.show', $customer));
    }

    /** @test */
    public function admin_can_view_customer_details()
    {
        $customer = Customer::factory()->create([
            'name' => 'Jane Doe',
            'is_member' => true,
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.customers.show', $customer));

        $response->assertStatus(200);
        $response->assertSee('Jane Doe');
        $response->assertSee('Member');
    }

    /** @test */
    public function admin_can_update_member_status()
    {
        $customer = Customer::factory()->create([
            'is_member' => false,
        ]);

        $response = $this->actingAs($this->admin)
            ->patch(route('admin.customers.update-member-status', $customer), [
                'is_member' => true,
                'member_discount' => 10.0,
            ]);

        $response->assertRedirect();
        
        $customer->refresh();
        $this->assertTrue($customer->is_member);
        $this->assertEquals(10.0, $customer->member_discount);
    }

    /** @test */
    public function admin_can_blacklist_customer()
    {
        $customer = Customer::factory()->create([
            'is_blacklisted' => false,
        ]);

        $response = $this->actingAs($this->admin)
            ->patch(route('admin.customers.update-blacklist-status', $customer), [
                'is_blacklisted' => true,
                'blacklist_reason' => 'Repeated violations of rental terms',
            ]);

        $response->assertRedirect();
        
        $customer->refresh();
        $this->assertTrue($customer->is_blacklisted);
        $this->assertEquals('Repeated violations of rental terms', $customer->blacklist_reason);
    }

    /** @test */
    public function admin_can_view_members_page()
    {
        Customer::factory()->create(['is_member' => true, 'name' => 'Member Customer']);
        Customer::factory()->create(['is_member' => false, 'name' => 'Regular Customer']);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.customers.members'));

        $response->assertStatus(200);
        $response->assertSee('Member Customers');
    }

    /** @test */
    public function admin_can_view_blacklist_page()
    {
        Customer::factory()->create(['is_blacklisted' => true, 'name' => 'Blacklisted Customer']);
        Customer::factory()->create(['is_blacklisted' => false, 'name' => 'Active Customer']);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.customers.blacklist'));

        $response->assertStatus(200);
        $response->assertSee('Blacklisted Customers');
    }

    /** @test */
    public function customer_member_discount_calculation_works()
    {
        $customer = Customer::factory()->create([
            'is_member' => true,
            'member_discount' => 15.0,
        ]);

        $originalAmount = 1000000; // 1 million IDR
        $discountedAmount = $customer->applyMemberDiscount($originalAmount);
        $expectedAmount = $originalAmount * 0.85; // 15% discount

        $this->assertEquals($expectedAmount, $discountedAmount);
    }

    /** @test */
    public function blacklisted_customer_cannot_make_booking()
    {
        $customer = Customer::factory()->create([
            'is_blacklisted' => true,
        ]);

        $this->assertFalse($customer->canMakeBooking());
    }
}