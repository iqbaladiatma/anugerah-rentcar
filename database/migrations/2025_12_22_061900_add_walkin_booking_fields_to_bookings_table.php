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
        Schema::table('bookings', function (Blueprint $table) {
            // Booking Type: online (customer registered), walkin (admin input langsung)
            $table->enum('booking_type', ['online', 'walkin'])->default('online')->after('booking_number');
            
            // Admin yang membuat booking walk-in
            $table->foreignId('admin_id')->nullable()->after('booking_type')->constrained('users')->onDelete('set null');
            
            // Data customer walk-in (untuk yang tidak punya akun)
            $table->string('walkin_customer_name')->nullable()->after('admin_id');
            $table->string('walkin_customer_phone')->nullable()->after('walkin_customer_name');
            $table->string('walkin_customer_id_number')->nullable()->after('walkin_customer_phone'); // NIK/SIM
            $table->string('walkin_customer_address')->nullable()->after('walkin_customer_id_number');
            
            // Customer ID menjadi nullable untuk walk-in booking
            $table->foreignId('customer_id')->nullable()->change();
            
            // Index
            $table->index('booking_type');
            $table->index('admin_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex(['booking_type']);
            $table->dropIndex(['admin_id']);
            
            $table->dropForeign(['admin_id']);
            
            $table->dropColumn([
                'booking_type',
                'admin_id',
                'walkin_customer_name',
                'walkin_customer_phone',
                'walkin_customer_id_number',
                'walkin_customer_address',
            ]);
        });
    }
};
