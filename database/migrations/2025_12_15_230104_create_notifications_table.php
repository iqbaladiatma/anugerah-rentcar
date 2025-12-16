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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // maintenance, stnk_expiry, payment_overdue, booking_confirmation, etc.
            $table->string('title');
            $table->text('message');
            $table->text('details')->nullable();
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->json('data')->nullable(); // Additional data for the notification
            $table->string('action_url')->nullable();
            $table->string('icon')->nullable();
            
            // Polymorphic relationship to any model (car, booking, customer, etc.)
            $table->nullableMorphs('notifiable');
            
            // Who should receive this notification
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('recipient_type')->default('user'); // user, customer, all_staff
            
            // Delivery tracking
            $table->timestamp('read_at')->nullable();
            $table->timestamp('email_sent_at')->nullable();
            $table->timestamp('sms_sent_at')->nullable();
            $table->json('delivery_status')->nullable(); // Track delivery attempts and results
            
            // Status
            $table->boolean('is_active')->default(true);
            $table->timestamp('expires_at')->nullable();
            
            $table->timestamps();
            
            $table->index(['type', 'is_active']);
            $table->index(['user_id', 'read_at']);
            $table->index(['priority', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
