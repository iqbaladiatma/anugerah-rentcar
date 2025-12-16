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
        Schema::create('notification_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('notification_type'); // maintenance, stnk_expiry, payment_overdue, etc.
            
            // Delivery method preferences
            $table->boolean('email_enabled')->default(true);
            $table->boolean('sms_enabled')->default(false);
            $table->boolean('browser_enabled')->default(true);
            
            // Timing preferences
            $table->time('preferred_time')->nullable(); // Preferred time for daily digest
            $table->boolean('instant_notifications')->default(true);
            $table->boolean('daily_digest')->default(false);
            
            // Priority filtering
            $table->json('priority_filter')->nullable(); // Which priorities to receive ['high', 'medium', 'low']
            
            $table->timestamps();
            
            $table->unique(['user_id', 'notification_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_preferences');
    }
};
