<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Add performance indexes for frequently queried columns.
 * These indexes optimize common query patterns in the application.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Bookings table indexes
        $this->addIndexIfNotExists('bookings', 'booking_status', 'bookings_booking_status_index');
        $this->addIndexIfNotExists('bookings', 'payment_status', 'bookings_payment_status_index');
        $this->addIndexIfNotExists('bookings', ['booking_status', 'start_date', 'end_date'], 'bookings_status_dates_index');
        $this->addIndexIfNotExists('bookings', ['customer_id', 'booking_status'], 'bookings_customer_status_index');
        $this->addIndexIfNotExists('bookings', ['car_id', 'booking_status', 'start_date', 'end_date'], 'bookings_car_status_dates_index');
        $this->addIndexIfNotExists('bookings', ['created_at', 'booking_status'], 'bookings_created_status_index');

        // Cars table indexes
        $this->addIndexIfNotExists('cars', 'status', 'cars_status_index');
        $this->addIndexIfNotExists('cars', ['last_oil_change', 'stnk_expiry'], 'cars_maintenance_index');
        $this->addIndexIfNotExists('cars', ['brand', 'model'], 'cars_brand_model_index');
        $this->addIndexIfNotExists('cars', 'daily_rate', 'cars_daily_rate_index');

        // Customers table indexes
        $this->addIndexIfNotExists('customers', 'is_member', 'customers_is_member_index');
        $this->addIndexIfNotExists('customers', 'is_blacklisted', 'customers_is_blacklisted_index');
        $this->addIndexIfNotExists('customers', ['name', 'phone'], 'customers_name_phone_index');

        // Expenses table indexes
        $this->addIndexIfNotExists('expenses', 'category', 'expenses_category_index');
        $this->addIndexIfNotExists('expenses', 'expense_date', 'expenses_expense_date_index');
        $this->addIndexIfNotExists('expenses', ['category', 'expense_date'], 'expenses_category_date_index');

        // Maintenances table indexes
        $this->addIndexIfNotExists('maintenances', 'car_id', 'maintenances_car_id_index');
        $this->addIndexIfNotExists('maintenances', 'service_date', 'maintenances_service_date_index');
        $this->addIndexIfNotExists('maintenances', 'maintenance_type', 'maintenances_type_index');

        // Notifications table indexes
        $this->addIndexIfNotExists('notifications', ['user_id', 'is_active'], 'notifications_user_active_index');
        $this->addIndexIfNotExists('notifications', 'recipient_type', 'notifications_recipient_type_index');
    }

    /**
     * Add index if it doesn't already exist.
     */
    private function addIndexIfNotExists(string $table, string|array $columns, string $indexName): void
    {
        $connection = DB::connection()->getDriverName();
        
        // Check if index exists based on database driver
        $indexExists = false;
        
        if ($connection === 'mysql') {
            $result = DB::select("SHOW INDEX FROM `{$table}` WHERE Key_name = ?", [$indexName]);
            $indexExists = count($result) > 0;
        } elseif ($connection === 'sqlite') {
            $result = DB::select("SELECT name FROM sqlite_master WHERE type='index' AND name = ?", [$indexName]);
            $indexExists = count($result) > 0;
        } elseif ($connection === 'pgsql') {
            $result = DB::select("SELECT indexname FROM pg_indexes WHERE indexname = ?", [$indexName]);
            $indexExists = count($result) > 0;
        }
        
        if (!$indexExists) {
            Schema::table($table, function (Blueprint $blueprint) use ($columns, $indexName) {
                $blueprint->index($columns, $indexName);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex('bookings_booking_status_index');
            $table->dropIndex('bookings_payment_status_index');
            $table->dropIndex('bookings_status_dates_index');
            $table->dropIndex('bookings_customer_status_index');
            $table->dropIndex('bookings_car_status_dates_index');
            $table->dropIndex('bookings_created_status_index');
        });

        Schema::table('cars', function (Blueprint $table) {
            $table->dropIndex('cars_status_index');
            $table->dropIndex('cars_maintenance_index');
            $table->dropIndex('cars_brand_model_index');
            $table->dropIndex('cars_daily_rate_index');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->dropIndex('customers_is_member_index');
            $table->dropIndex('customers_is_blacklisted_index');
            $table->dropIndex('customers_name_phone_index');
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->dropIndex('expenses_category_index');
            $table->dropIndex('expenses_expense_date_index');
            $table->dropIndex('expenses_category_date_index');
        });

        Schema::table('maintenances', function (Blueprint $table) {
            $table->dropIndex('maintenances_car_id_index');
            $table->dropIndex('maintenances_service_date_index');
            $table->dropIndex('maintenances_type_index');
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->dropIndex('notifications_user_active_index');
            $table->dropIndex('notifications_recipient_type_index');
        });
    }
};
