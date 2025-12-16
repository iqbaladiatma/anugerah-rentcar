<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\Customer;
use App\Models\Booking;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicVehicleSearchTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create default settings
        Setting::updateSettings([
            'company_name' => 'Anugerah Rentcar',
            'buffer_time_hours' => 3,
            'late_penalty_per_hour' => 50000,
            'member_discount_percentage' => 10,
        ]);
    }

    public function test_vehicle_catalog_displays_available_vehicles()
    {
        // Create test vehicles
        $availableCar = Car::factory()->create([
            'status' => Car::STATUS_AVAILABLE,
            'brand' => 'Toyota',
            'model' => 'Avanza',
            'daily_rate' => 300000,
        ]);

        $rentedCar = Car::factory()->create([
            'status' => Car::STATUS_RENTED,
            'brand' => 'Honda',
            'model' => 'Civic',
        ]);

        $response = $this->get(route('vehicles.catalog'));

        $response->assertStatus(200);
        $response->assertSee($availableCar->brand);
        $response->assertSee($availableCar->model);
        $response->assertDontSee($rentedCar->brand);
    }

    public function test_vehicle_search_with_date_range_filtering()
    {
        $car = Car::factory()->create([
            'status' => Car::STATUS_AVAILABLE,
            'brand' => 'Toyota',
            'model' => 'Avanza',
            'daily_rate' => 300000,
            'license_plate' => 'B 5555 FLT',
        ]);

        $customer = Customer::factory()->create();

        // Create a booking that conflicts with our search dates
        Booking::factory()->create([
            'car_id' => $car->id,
            'customer_id' => $customer->id,
            'start_date' => Carbon::now()->addDays(2),
            'end_date' => Carbon::now()->addDays(4),
            'booking_status' => 'confirmed',
        ]);

        // Search for dates that conflict with the booking
        $response = $this->get(route('vehicles.catalog', [
            'start_date' => Carbon::now()->addDays(3)->format('Y-m-d'),
            'end_date' => Carbon::now()->addDays(5)->format('Y-m-d'),
        ]));

        $response->assertStatus(200);
        // Should not show the car's license plate since it's booked during this period
        $response->assertDontSee($car->license_plate);
    }

    public function test_vehicle_search_ajax_endpoint()
    {
        $car = Car::factory()->create([
            'status' => Car::STATUS_AVAILABLE,
            'brand' => 'Toyota',
            'model' => 'Avanza',
            'daily_rate' => 300000,
            'weekly_rate' => 1800000,
        ]);

        $response = $this->postJson(route('vehicles.search'), [
            'start_date' => Carbon::now()->addDays(1)->format('Y-m-d'),
            'end_date' => Carbon::now()->addDays(3)->format('Y-m-d'),
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $responseData = $response->json();
        $this->assertArrayHasKey('vehicles', $responseData);
        $this->assertCount(1, $responseData['vehicles']);
        
        $vehicleData = $responseData['vehicles'][0];
        $this->assertEquals($car->id, $vehicleData['id']);
        $this->assertEquals($car->brand, $vehicleData['brand']);
        $this->assertEquals($car->model, $vehicleData['model']);
        $this->assertEquals(3, $vehicleData['duration']); // 3 days
        $this->assertEquals(900000, $vehicleData['total_price']); // 3 * 300000
    }

    public function test_vehicle_show_page_displays_vehicle_details()
    {
        $car = Car::factory()->create([
            'status' => Car::STATUS_AVAILABLE,
            'brand' => 'Toyota',
            'model' => 'Avanza',
            'year' => 2020,
            'color' => 'Silver',
            'daily_rate' => 300000,
            'driver_fee_per_day' => 150000,
        ]);

        $response = $this->get(route('vehicles.show', $car));

        $response->assertStatus(200);
        $response->assertSee($car->brand);
        $response->assertSee($car->model);
        $response->assertSee($car->year);
        $response->assertSee($car->color);
        $response->assertSee(number_format($car->daily_rate, 0, ',', '.'));
        $response->assertSee('Book This Vehicle');
    }

    public function test_unavailable_vehicle_returns_404()
    {
        $car = Car::factory()->create([
            'status' => Car::STATUS_MAINTENANCE,
        ]);

        $response = $this->get(route('vehicles.show', $car));

        $response->assertStatus(404);
    }

    public function test_vehicle_catalog_with_brand_filter()
    {
        $toyotaCar = Car::factory()->create([
            'status' => Car::STATUS_AVAILABLE,
            'brand' => 'Toyota',
            'model' => 'Avanza',
            'license_plate' => 'B 1111 TOY',
        ]);

        $hondaCar = Car::factory()->create([
            'status' => Car::STATUS_AVAILABLE,
            'brand' => 'Honda',
            'model' => 'Civic',
            'license_plate' => 'B 2222 HON',
        ]);

        $response = $this->get(route('vehicles.catalog', ['brand' => 'Toyota']));

        $response->assertStatus(200);
        // Check that Toyota car's license plate is shown (in vehicle card)
        $response->assertSee($toyotaCar->license_plate);
        // Check that Honda car's license plate is NOT shown (not in vehicle cards)
        $response->assertDontSee($hondaCar->license_plate);
    }

    public function test_vehicle_catalog_with_price_filter()
    {
        $cheapCar = Car::factory()->create([
            'status' => Car::STATUS_AVAILABLE,
            'brand' => 'Toyota',
            'daily_rate' => 250000,
            'license_plate' => 'B 3333 CHE',
        ]);

        $expensiveCar = Car::factory()->create([
            'status' => Car::STATUS_AVAILABLE,
            'brand' => 'BMW',
            'daily_rate' => 800000,
            'license_plate' => 'B 4444 EXP',
        ]);

        $response = $this->get(route('vehicles.catalog', ['max_price' => 300000]));

        $response->assertStatus(200);
        // Check that cheap car's license plate is shown (in vehicle card)
        $response->assertSee($cheapCar->license_plate);
        // Check that expensive car's license plate is NOT shown (not in vehicle cards)
        $response->assertDontSee($expensiveCar->license_plate);
    }

    public function test_vehicle_search_calculates_weekly_discount()
    {
        $car = Car::factory()->create([
            'status' => Car::STATUS_AVAILABLE,
            'daily_rate' => 300000,
            'weekly_rate' => 1800000, // Cheaper than 7 * daily_rate (2100000)
        ]);

        // Search for 7 days (should get weekly rate)
        $response = $this->postJson(route('vehicles.search'), [
            'start_date' => Carbon::now()->addDays(1)->format('Y-m-d'),
            'end_date' => Carbon::now()->addDays(7)->format('Y-m-d'),
        ]);

        $response->assertStatus(200);
        
        $vehicleData = $response->json('vehicles')[0];
        $this->assertEquals(1800000, $vehicleData['total_price']); // Weekly rate
        $this->assertEquals(300000, $vehicleData['weekly_discount']); // Savings from weekly rate
    }
}