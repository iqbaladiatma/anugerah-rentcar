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
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained()->onDelete('cascade');
            $table->enum('maintenance_type', ['routine', 'repair', 'inspection']);
            $table->text('description');
            $table->decimal('cost', 10, 2);
            $table->date('service_date');
            $table->date('next_service_date')->nullable();
            $table->integer('odometer_at_service');
            $table->string('service_provider');
            $table->string('receipt_photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};