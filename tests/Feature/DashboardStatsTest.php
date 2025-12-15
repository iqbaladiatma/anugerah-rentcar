<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Car;
use App\Models\Customer;
use App\Models\Booking;
use App\Models\Setting;
use Carbon\Carbon;
use Livewire\Livewire;
use App\Livewire\Admin\DashboardStats;

class DashboardStatsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create default settings
        Setting::create([
            'company_name' => 'Anugerah Rentcar',
            'company_address' => 'Jakarta, Indonesia',
            'company_phone' => '+62 21 1234567',
            'buffer_time_hours' => 3,
            'late_penalty_per_hour' => 50000,
            'member_discount_percentage' => 10,
        ]);
    }

    public function test_dashboard_stats_component_renders(): void
    {
        $user = User::factory()->create(['role' => 'admin']);

        $this->actingAs($user);

        Livewire::test(DashboardStats::class)
            ->assertStatus(200)
            ->assertSee('Total Vehicles')
            ->assertSee('Active Bookings')
            ->assertSee('Available Now')
            ->assertSee('Monthly Revenue');
    }

    public function test_dashboard_shows_correct_vehicle_statistics(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        
        // Create test vehicles
        Car::factory()->count(5)->create(['status' => 'available']);
        Car::factory()->count(2)->create(['status' => 'rented']);
        Car::factory()->count(1)->create(['status' => 'maintenance']);

        $this->actingAs($user);

        Livewire::test(DashboardStats::class)
            ->assertSee('8') // Total vehicles
            ->assertSee('5'); // Available vehicles
    }

    public function test_dashboard_shows_correct_booking_statistics(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $customer = Customer::factory()->create();
        $car = Car::factory()->create();

        // Create test bookings
        Booking::factory()->count(3)->create([
            'customer_id' => $customer->id,
            'car_id' => $car->id,
            'booking_status' => 'active'
        ]);
        
        Booking::factory()->count(2)->create([
            'customer_id' => $customer->id,
            'car_id' => $car->id,
            'booking_status' => 'pending'
        ]);

        $this->actingAs($user);

        Livewire::test(DashboardStats::class)
            ->assertSee('3') // Active bookings
            ->assertSee('2'); // Pending bookings (in notifications)
    }

    public function test_dashboard_calculates_monthly_revenue(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $customer = Customer::factory()->create();
        $car = Car::factory()->create();

        // Create bookings for current month
        Booking::factory()->create([
            'customer_id' => $customer->id,
            'car_id' => $car->id,
            'booking_status' => 'completed',
            'total_amount' => 1000000,
            'created_at' => Carbon::now()
        ]);

        Booking::factory()->create([
            'customer_id' => $customer->id,
            'car_id' => $car->id,
            'booking_status' => 'active',
            'total_amount' => 500000,
            'created_at' => Carbon::now()
        ]);

        $this->actingAs($user);

        Livewire::test(DashboardStats::class)
            ->assertSee('1,500,000'); // Total monthly revenue formatted
    }

    public function test_dashboard_shows_recent_bookings(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $customer = Customer::factory()->create(['name' => 'John Doe']);
        $car = Car::factory()->create([
            'brand' => 'Toyota',
            'model' => 'Avanza',
            'license_plate' => 'B 1234 ABC'
        ]);

        Booking::factory()->create([
            'customer_id' => $customer->id,
            'car_id' => $car->id,
            'booking_status' => 'active'
        ]);

        $this->actingAs($user);

        Livewire::test(DashboardStats::class)
            ->assertSee('John Doe')
            ->assertSee('Toyota Avanza')
            ->assertSee('B 1234 ABC')
            ->assertSee('Active');
    }

    public function test_dashboard_shows_maintenance_notifications(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        
        // Create car needing oil change
        Car::factory()->create([
            'license_plate' => 'B 1111 AAA',
            'last_oil_change' => Carbon::now()->subDays(100), // Overdue
        ]);

        // Create car with expiring STNK
        Car::factory()->create([
            'license_plate' => 'B 2222 BBB',
            'stnk_expiry' => Carbon::now()->addDays(5), // Expires soon
        ]);

        $this->actingAs($user);

        Livewire::test(DashboardStats::class)
            ->assertSee('Oil change due for B 1111 AAA')
            ->assertSee('STNK expires soon for B 2222 BBB')
            ->assertSee('urgent'); // Should show urgent notifications
    }

    public function test_dashboard_refreshes_stats(): void
    {
        $user = User::factory()->create(['role' => 'admin']);

        $this->actingAs($user);

        Livewire::test(DashboardStats::class)
            ->call('refreshStats')
            ->assertDispatched('stats-refreshed');
    }
}