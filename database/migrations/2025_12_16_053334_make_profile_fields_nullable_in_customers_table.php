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
        Schema::table('customers', function (Blueprint $table) {
            // Make profile fields nullable since they will be filled in stage 2
            $table->string('phone', 20)->nullable()->change();
            $table->string('nik', 16)->nullable()->change();
            $table->text('address')->nullable()->change();
            $table->string('ktp_photo')->nullable()->change();
            $table->string('sim_photo')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            // Revert back to required
            $table->string('phone', 20)->nullable(false)->change();
            $table->string('nik', 16)->nullable(false)->change();
            $table->text('address')->nullable(false)->change();
            $table->string('ktp_photo')->nullable(false)->change();
            $table->string('sim_photo')->nullable(false)->change();
        });
    }
};
