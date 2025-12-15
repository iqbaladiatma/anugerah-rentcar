<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Car;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class BookingManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create admin user
        $this->admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
            'is_active' => true,
        ]);
    }

    /** @test */
    public function admin_can_view_booking_index_page()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.bookings.index'));
        
        $response->assertStatus(200);
        $response->assertViewIs('admin.bookings.index');
    }

    /** @test */
    public function admin_can_view_booking_create_page()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.bookings.create'));
        
        $response->assertStatus(200);
        $response->assertViewIs('admin.bookings.create');
    }

    /** @test */
    public function admin_can_create_booking()
    {
        $customer = Customer::factory()->create(['is_blacklisted' => false]);
        $car = Car::factory()->create(['status' => Car::STATUS_AVAILABLE]);
        $driver = User::factory()->create(['role' => User::ROLE_DRIVER, 'is_active' => true]);

        $bookingData = [
            'customer_id' => $customer->id,
            'car_id' => $car->id,
            'driver_id' => $driver->id,
            'start_date' => Carbon::now()->addDay()->format('Y-m-d H:i:s'),
            'end_date' => Carbon::now()->addDays(3)->format('Y-m-d H:i:s'),
            'pickup_location' => 'Office Location',
            'return_location' => 'Office Location',
            'with_driver' => true,
            'is_out_of_town' => false,
            'out_of_town_fee' => 0,
            'notes' => 'Test booking',
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.bookings.store'), $bookingData);

        $response->assertRedirect();
        
        $this->assertDatabaseHas('bookings', [
            'customer_id' => $customer->id,
            'car_id' => $car->id,
            'driver_id' => $driver->id,
            'booking_status' => Booking::STATUS_PENDING,
            'payment_status' => Booking::PAYMENT_PENDING,
        ]);
    }

    /** @test */
    public function admin_can_view_booking_details()
    {
        $booking = Booking::factory()->create();
        
        $response = $this->actingAs($this->admin)
            ->get(route('admin.bookings.show', $booking));
        
        $response->assertStatus(200);
        $response->assertViewIs('admin.bookings.show');
        $response->assertViewHas('booking', $booking);
    }

    /** @test */
    public function admin_can_confirm_pending_booking()
    {
        $booking = Booking::factory()->create([
            'booking_status' => Booking::STATUS_PENDING
        ]);

        $response = $this->actingAs($this->admin)
            ->patch(route('admin.bookings.confirm', $booking));

        $response->assertRedirect();
        
        $booking->refresh();
        $this->assertEquals(Booking::STATUS_CONFIRMED, $booking->booking_status);
        $this->assertEquals(Car::STATUS_RENTED, $booking->car->status);
    }

    /** @test */
    public function admin_can_activate_confirmed_booking()
    {
        $booking = Booking::factory()->create([
            'booking_status' => Booking::STATUS_CONFIRMED
        ]);

        $response = $this->actingAs($this->admin)
            ->patch(route('admin.bookings.activate', $booking));

        $response->assertRedirect();
        
        $booking->refresh();
        $this->assertEquals(Booking::STATUS_ACTIVE, $booking->booking_status);
    }

    /** @test */
    public function admin_can_complete_active_booking()
    {
        $booking = Booking::factory()->create([
            'booking_status' => Booking::STATUS_ACTIVE
        ]);

        $response = $this->actingAs($this->admin)
            ->patch(route('admin.bookings.complete', $booking), [
                'actual_return_date' => Carbon::now()->format('Y-m-d H:i:s')
            ]);

        $response->assertRedirect();
        
        $booking->refresh();
        $this->assertEquals(Booking::STATUS_COMPLETED, $booking->booking_status);
        $this->assertEquals(Car::STATUS_AVAILABLE, $booking->car->status);
    }

    /** @test */
    public function admin_can_cancel_booking()
    {
        $booking = Booking::factory()->create([
            'booking_status' => Booking::STATUS_PENDING
        ]);

        $response = $this->actingAs($this->admin)
            ->patch(route('admin.bookings.cancel', $booking), [
                'cancellation_reason' => 'Customer request'
            ]);

        $response->assertRedirect();
        
        $booking->refresh();
        $this->assertEquals(Booking::STATUS_CANCELLED, $booking->booking_status);
        $this->assertEquals(Car::STATUS_AVAILABLE, $booking->car->status);
    }

    /** @test */
    public function blacklisted_customer_cannot_create_booking()
    {
        $customer = Customer::factory()->create(['is_blacklisted' => true]);
        $car = Car::factory()->create(['status' => Car::STATUS_AVAILABLE]);

        $bookingData = [
            'customer_id' => $customer->id,
            'car_id' => $car->id,
            'start_date' => Carbon::now()->addDay()->format('Y-m-d H:i:s'),
            'end_date' => Carbon::now()->addDays(3)->format('Y-m-d H:i:s'),
            'pickup_location' => 'Office Location',
            'return_location' => 'Office Location',
            'with_driver' => false,
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.bookings.store'), $bookingData);

        $response->assertRedirect();
        $response->assertSessionHas('error');
        
        $this->assertDatabaseMissing('bookings', [
            'customer_id' => $customer->id,
            'car_id' => $car->id,
        ]);
    }

    /** @test */
    public function booking_pricing_calculation_works()
    {
        $customer = Customer::factory()->create([
            'is_member' => true,
            'member_discount' => 15
        ]);
        $car = Car::factory()->create([
            'daily_rate' => 300000,
            'driver_fee_per_day' => 100000,
            'status' => Car::STATUS_AVAILABLE
        ]);

        $bookingData = [
            'customer_id' => $customer->id,
            'car_id' => $car->id,
            'start_date' => Carbon::now()->addDay()->format('Y-m-d H:i:s'),
            'end_date' => Carbon::now()->addDays(3)->format('Y-m-d H:i:s'), // 3 days
            'pickup_location' => 'Office Location',
            'return_location' => 'Office Location',
            'with_driver' => true,
            'is_out_of_town' => false,
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.bookings.store'), $bookingData);

        $booking = Booking::latest()->first();
        
        // 3 days * 300,000 = 900,000 (base)
        // 3 days * 100,000 = 300,000 (driver)
        // Subtotal = 1,200,000
        // Member discount 15% = 180,000
        // Total = 1,020,000
        
        $this->assertEquals(900000, $booking->base_amount);
        $this->assertEquals(300000, $booking->driver_fee);
        $this->assertEquals(180000, $booking->member_discount);
        $this->assertEquals(1020000, $booking->total_amount);
    }

    /** @test */
    public function booking_generates_unique_booking_number()
    {
        $booking1 = Booking::factory()->create();
        $booking2 = Booking::factory()->create();

        $this->assertNotEquals($booking1->booking_number, $booking2->booking_number);
        $this->assertStringStartsWith('BK', $booking1->booking_number);
        $this->assertStringStartsWith('BK', $booking2->booking_number);
    }

    /** @test */
    public function late_penalty_calculation_works()
    {
        $booking = Booking::factory()->create([
            'booking_status' => Booking::STATUS_ACTIVE,
            'end_date' => Carbon::now()->subHours(5), // 5 hours late
        ]);

        $booking->update(['actual_return_date' => Carbon::now()]);
        $booking->updateLatePenalty();

        // Should calculate 5 hours * penalty rate
        $this->assertGreaterThan(0, $booking->late_penalty);
    }
}