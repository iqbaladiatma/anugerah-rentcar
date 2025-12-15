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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_number')->unique();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('car_id')->constrained()->onDelete('cascade');
            $table->foreignId('driver_id')->nullable()->constrained('users')->onDelete('set null');
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->datetime('actual_return_date')->nullable();
            $table->string('pickup_location');
            $table->string('return_location');
            $table->boolean('with_driver')->default(false);
            $table->boolean('is_out_of_town')->default(false);
            $table->decimal('out_of_town_fee', 8, 2)->default(0);
            $table->decimal('base_amount', 10, 2);
            $table->decimal('driver_fee', 8, 2)->default(0);
            $table->decimal('member_discount', 8, 2)->default(0);
            $table->decimal('late_penalty', 8, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->decimal('deposit_amount', 8, 2);
            $table->enum('payment_status', ['pending', 'partial', 'paid', 'refunded'])->default('pending');
            $table->enum('booking_status', ['pending', 'confirmed', 'active', 'completed', 'cancelled'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};