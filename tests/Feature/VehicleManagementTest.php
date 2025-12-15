<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class VehicleManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a test user
        $this->user = User::factory()->create([
            'role' => 'admin',
        ]);
        
        Storage::fake('public');
    }

    /** @test */
    public function admin_can_view_vehicle_index_page()
    {
        $this->actingAs($this->user)
            ->get(route('admin.vehicles.index'))
            ->assertStatus(200)
            ->assertSee('Vehicle Management');
    }

    /** @test */
    public function admin_can_view_vehicle_create_page()
    {
        $this->actingAs($this->user)
            ->get(route('admin.vehicles.create'))
            ->assertStatus(200)
            ->assertSee('Add New Vehicle');
    }

    /** @test */
    public function admin_can_create_vehicle()
    {
        $vehicleData = [
            'license_plate' => 'B 1234 TEST',
            'brand' => 'Toyota',
            'model' => 'Avanza',
            'year' => 2023,
            'color' => 'White',
            'stnk_number' => 'STNK123456',
            'stnk_expiry' => now()->addYear()->format('Y-m-d'),
            'current_odometer' => 10000,
            'daily_rate' => 300000,
            'weekly_rate' => 1800000,
            'driver_fee_per_day' => 100000,
            'status' => 'available',
        ];

        $response = $this->actingAs($this->user)
            ->post(route('admin.vehicles.store'), $vehicleData);

        $this->assertDatabaseHas('cars', [
            'license_plate' => 'B 1234 TEST',
            'brand' => 'Toyota',
            'model' => 'Avanza',
        ]);

        $vehicle = Car::where('license_plate', 'B 1234 TEST')->first();
        $response->assertRedirect(route('admin.vehicles.show', $vehicle));
    }

    /** @test */
    public function admin_can_view_vehicle_details()
    {
        $vehicle = Car::factory()->create([
            'license_plate' => 'B 5678 TEST',
            'brand' => 'Honda',
            'model' => 'Brio',
        ]);

        $this->actingAs($this->user)
            ->get(route('admin.vehicles.show', $vehicle))
            ->assertStatus(200)
            ->assertSee('B 5678 TEST')
            ->assertSee('Honda Brio');
    }

    /** @test */
    public function admin_can_update_vehicle_status()
    {
        $vehicle = Car::factory()->create(['status' => 'available']);

        $this->actingAs($this->user)
            ->patch(route('admin.vehicles.update-status', $vehicle), [
                'status' => 'maintenance',
                'reason' => 'Scheduled maintenance',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('cars', [
            'id' => $vehicle->id,
            'status' => 'maintenance',
        ]);
    }

    /** @test */
    public function vehicle_maintenance_notifications_are_generated()
    {
        // Create vehicle with overdue oil change
        $vehicle = Car::factory()->create([
            'license_plate' => 'B 9999 TEST',
            'last_oil_change' => now()->subDays(100), // Overdue
        ]);

        $notifications = $vehicle->getMaintenanceNotifications();

        $this->assertNotEmpty($notifications);
        $this->assertEquals('oil_change', $notifications[0]['type']);
        $this->assertStringContainsString('Oil change due', $notifications[0]['message']);
    }

    /** @test */
    public function vehicle_availability_calculation_works()
    {
        $vehicle = Car::factory()->create(['status' => 'available']);

        $startDate = now()->addDay();
        $endDate = now()->addDays(3);

        $this->assertTrue($vehicle->isAvailableForPeriod($startDate, $endDate));

        // Change status to maintenance
        $vehicle->update(['status' => 'maintenance']);
        $this->assertFalse($vehicle->isAvailableForPeriod($startDate, $endDate));
    }

    /** @test */
    public function admin_can_view_maintenance_due_page()
    {
        // Create vehicle needing maintenance
        Car::factory()->create([
            'license_plate' => 'B 1111 MAINT',
            'last_oil_change' => now()->subDays(100),
        ]);

        $this->actingAs($this->user)
            ->get(route('admin.vehicles.maintenance-due'))
            ->assertStatus(200)
            ->assertSee('Vehicles Requiring Maintenance');
    }
}