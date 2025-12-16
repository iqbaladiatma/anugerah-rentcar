<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Booking;
use App\Models\Car;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Disable CSRF for testing
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);
        
        // Create a test customer
        $this->customer = Customer::factory()->create([
            'name' => 'Test Customer',
            'email' => 'test@example.com',
            'phone' => '081234567890',
            'nik' => '1234567890123456',
            'address' => 'Test Address',
            'is_member' => true,
            'member_discount' => 10.00,
        ]);
    }

    public function test_customer_can_access_dashboard()
    {
        $response = $this->actingAs($this->customer, 'customer')
                        ->get(route('customer.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Welcome back, Test Customer!');
        $response->assertSee('Total Bookings');
        $response->assertSee('Active Bookings');
        $response->assertSee('Completed');
        $response->assertSee('Total Spent');
    }

    public function test_customer_can_view_bookings_page()
    {
        $response = $this->actingAs($this->customer, 'customer')
                        ->get(route('customer.bookings'));

        $response->assertStatus(200);
        $response->assertSee('My Bookings');
        $response->assertSee('View and manage your rental bookings');
    }

    public function test_customer_can_view_profile_page()
    {
        $response = $this->actingAs($this->customer, 'customer')
                        ->get(route('customer.profile'));

        $response->assertStatus(200);
        $response->assertSee('My Profile');
        $response->assertSee('Test Customer');
        $response->assertSee('test@example.com');
        $response->assertSee('Premium Member');
    }

    public function test_customer_can_view_support_page()
    {
        $response = $this->actingAs($this->customer, 'customer')
                        ->get(route('customer.support'));

        $response->assertStatus(200);
        $response->assertSee('Customer Support');
        $response->assertSee('Submit Support Request');
    }

    public function test_customer_can_update_profile()
    {
        $response = $this->actingAs($this->customer, 'customer')
                        ->from(route('customer.profile'))
                        ->withSession(['_token' => 'test-token'])
                        ->patch(route('customer.profile.update'), [
                            '_token' => 'test-token',
                            'name' => 'Updated Name',
                            'email' => 'updated@example.com',
                            'phone' => '081234567891',
                            'address' => 'Updated Address',
                        ]);

        $response->assertRedirect();
        
        $this->customer->refresh();
        $this->assertEquals('Updated Name', $this->customer->name);
        $this->assertEquals('updated@example.com', $this->customer->email);
    }

    public function test_customer_can_view_booking_details()
    {
        // Create a car and booking for testing
        $car = Car::factory()->create([
            'brand' => 'Toyota',
            'model' => 'Avanza',
            'license_plate' => 'B1234ABC',
        ]);

        $booking = Booking::factory()->create([
            'customer_id' => $this->customer->id,
            'car_id' => $car->id,
            'booking_number' => 'BK20241215001',
            'booking_status' => 'confirmed',
            'total_amount' => 500000,
        ]);

        $response = $this->actingAs($this->customer, 'customer')
                        ->get(route('customer.bookings.show', $booking));

        $response->assertStatus(200);
        $response->assertSee('Booking Details');
        $response->assertSee('BK20241215001');
        $response->assertSee('Toyota Avanza');
        $response->assertSee('B1234ABC');
    }

    public function test_customer_can_download_eticket_for_confirmed_booking()
    {
        $car = Car::factory()->create();
        $booking = Booking::factory()->create([
            'customer_id' => $this->customer->id,
            'car_id' => $car->id,
            'booking_status' => 'confirmed',
            'booking_number' => 'BK20241215003',
            'base_amount' => 300000,
            'driver_fee' => 0,
            'member_discount' => 0,
            'late_penalty' => 0,
            'total_amount' => 300000,
            'deposit_amount' => 100000,
        ]);

        $response = $this->actingAs($this->customer, 'customer')
                        ->get(route('customer.bookings.ticket', $booking));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_customer_cannot_access_other_customer_booking()
    {
        $otherCustomer = Customer::factory()->create();
        $car = Car::factory()->create();
        $booking = Booking::factory()->create([
            'customer_id' => $otherCustomer->id,
            'car_id' => $car->id,
            'booking_number' => 'BK20241215002',
            'base_amount' => 300000,
            'driver_fee' => 0,
            'member_discount' => 0,
            'late_penalty' => 0,
            'total_amount' => 300000,
            'deposit_amount' => 100000,
        ]);

        $response = $this->actingAs($this->customer, 'customer')
                        ->get(route('customer.bookings.show', $booking));

        $response->assertStatus(403);
    }

    public function test_guest_cannot_access_customer_dashboard()
    {
        $response = $this->get(route('customer.dashboard'));
        $response->assertRedirect();
        // Should redirect to customer login, but the exact URL may vary based on middleware configuration
        $this->assertTrue($response->isRedirect());
    }

    public function test_customer_can_submit_support_request()
    {
        $response = $this->actingAs($this->customer, 'customer')
                        ->from(route('customer.support'))
                        ->withSession(['_token' => 'test-token'])
                        ->post(route('customer.support.submit'), [
                            '_token' => 'test-token',
                            'subject' => 'Test Support Request',
                            'category' => 'general',
                            'priority' => 'medium',
                            'message' => 'This is a test support request message.',
                        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }
}