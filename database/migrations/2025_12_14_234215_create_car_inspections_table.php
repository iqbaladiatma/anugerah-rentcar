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
        Schema::create('car_inspections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->enum('inspection_type', ['checkout', 'checkin']);
            $table->enum('fuel_level', ['empty', 'quarter', 'half', 'three_quarter', 'full']);
            $table->integer('odometer_reading');
            $table->json('exterior_condition');
            $table->json('interior_condition');
            $table->json('photos');
            $table->string('inspector_signature')->nullable();
            $table->string('customer_signature')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_inspections');
    }
};