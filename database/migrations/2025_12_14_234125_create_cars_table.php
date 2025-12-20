<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('license_plate')->unique();
            $table->string('brand');
            $table->string('model');
            $table->integer('year');
            $table->string('color');
            $table->string('stnk_number');
            $table->date('stnk_expiry');
            $table->date('last_oil_change')->nullable();
            $table->integer('oil_change_interval_km')->nullable();
            $table->integer('current_odometer');
            $table->decimal('daily_rate', 10, 2);
            $table->decimal('weekly_rate', 10, 2);
            $table->decimal('driver_fee_per_day', 15, 2);
            $table->string('photo_front')->nullable();
            $table->string('photo_side')->nullable();
            $table->string('photo_back')->nullable();
            $table->enum('status', ['available', 'rented', 'maintenance', 'inactive'])->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};