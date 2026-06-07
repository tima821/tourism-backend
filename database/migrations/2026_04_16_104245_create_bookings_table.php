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
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('trip_id')->constrained('trips');
            $table->string('booking_type', 50);
            $table->string('age_category', 50);
            $table->integer('seats_count')->default(1);
            $table->integer('hotel_rooms')->default(0);
            $table->string('national_id', 50);
            $table->string('passport_number', 50)->nullable();
            $table->decimal('booking_price', 10, 2);
            $table->string('booking_status', 50)->default('pending');
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
