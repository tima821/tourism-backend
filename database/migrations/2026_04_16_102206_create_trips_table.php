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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->string('trip_type', 50);
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->dateTime('booking_start_date');
            $table->dateTime('booking_end_date');
            $table->integer('available_seats');
            $table->integer('total_seats');
            $table->decimal('trip_cost', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
