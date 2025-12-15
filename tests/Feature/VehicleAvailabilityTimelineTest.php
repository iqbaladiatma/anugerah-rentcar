<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Car;
use App\Models\Customer;
use App\Models\Booking;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class VehicleAvailabilityTimelineTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create default settings
        Setting::create([
            'company_name' => 'Test Rentcar',
            'company_address' => 'Test Address',
            'company_phone' => '081234567890',
            'buffer_time_hours' => 3,
            'late_penalty_per_hour' => 50000,
            'member_discount_percentage' => 10,
        ]);
    }

    public function test_timeline_page_can_be_accessed_by_authenticated_user()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/availability/timeline');

        $response->assertStatus(200);
        $response->assertSeeLivewire('admin.vehicle-availability-timeline');
    }

    public function test_timeline_component_loads_with_default_date_range()
    {
        $user = User::factory()->create();
        
        // Create a test car
        $car = Car::factory()->create([
            'license_plate' => 'B1234XYZ',
            'brand' => 'Toyota',
            'model' => 'Avanza',
            'status' => 'available'
        ]);

        Livewire::actingAs($user)
            ->test('admin.vehicle-availability-timeline')
            ->assertSet('startDate', Carbon::now()->startOfWeek()->format('Y-m-d'))
            ->assertSet('endDate', Carbon::now()->endOfWeek()->format('Y-m-d'))
            ->assertSet('showAllCars', true)
            ->assertSee('Vehicle Availability Timeline')
            ->assertSee($car->license_plate);
    }

    public function test_timeline_shows_booking_information()
    {
        $user = User::factory()->create();
        
        // Create test data
        $car = Car::factory()->create([
            'license_plate' => 'B1234XYZ',
            'status' => 'available'
        ]);
        
        $customer = Customer::factory()->create([
            'name' => 'John Doe'
        ]);
        
        $booking = Booking::factory()->create([
            'car_id' => $car->id,
            'customer_id' => $customer->id,
            'start_date' => Carbon::now()->addDay(),
            'end_date' => Carbon::now()->addDays(2),
            'booking_status' => 'confirmed'
        ]);

        Livewire::actingAs($user)
            ->test('admin.vehicle-availability-timeline')
            ->call('showBookingDetails', $booking->id)
            ->assertSet('hoveredBooking.id', $booking->id)
            ->assertSee($booking->booking_number)
            ->assertSee($customer->name);
    }

    public function test_timeline_date_range_can_be_updated()
    {
        $user = User::factory()->create();
        
        $startDate = Carbon::now()->format('Y-m-d');
        $endDate = Carbon::now()->addDays(7)->format('Y-m-d');

        Livewire::actingAs($user)
            ->test('admin.vehicle-availability-timeline')
            ->set('startDate', $startDate)
            ->set('endDate', $endDate)
            ->assertSet('startDate', $startDate)
            ->assertSet('endDate', $endDate);
    }

    public function test_timeline_quick_date_range_selection()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test('admin.vehicle-availability-timeline')
            ->call('selectDateRange', 'today')
            ->assertSet('startDate', Carbon::now()->format('Y-m-d'))
            ->assertSet('endDate', Carbon::now()->format('Y-m-d'));
    }

    public function test_timeline_vehicle_filtering()
    {
        $user = User::factory()->create();
        
        $car1 = Car::factory()->create(['license_plate' => 'B1111ABC']);
        $car2 = Car::factory()->create(['license_plate' => 'B2222DEF']);

        Livewire::actingAs($user)
            ->test('admin.vehicle-availability-timeline')
            ->set('showAllCars', false)
            ->set('selectedCarIds', [$car1->id])
            ->assertSet('showAllCars', false)
            ->assertSet('selectedCarIds', [$car1->id]);
    }

    public function test_timeline_displays_fleet_summary()
    {
        $user = User::factory()->create();
        
        // Create cars with different statuses
        Car::factory()->create(['status' => 'available']);
        Car::factory()->create(['status' => 'available']);
        Car::factory()->create(['status' => 'maintenance']);

        Livewire::actingAs($user)
            ->test('admin.vehicle-availability-timeline')
            ->assertSee('Available Vehicles')
            ->assertSee('Total Fleet')
            ->assertSee('Availability Rate');
    }
}