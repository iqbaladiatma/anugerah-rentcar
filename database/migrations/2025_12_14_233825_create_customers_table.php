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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->string('phone', 20)->nullable();
            $table->string('nik', 16)->unique()->nullable();
            $table->string('ktp_photo')->nullable();
            $table->string('sim_photo')->nullable();
            $table->string('kk_photo')->nullable();
            $table->text('address')->nullable();
            $table->boolean('profile_completed')->default(false);
            $table->boolean('is_member')->default(false);
            $table->decimal('member_discount', 5, 2)->nullable();
            $table->boolean('is_blacklisted')->default(false);
            $table->text('blacklist_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};