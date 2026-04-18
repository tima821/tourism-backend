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
        Schema::create('trip_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->integer('seats_count');
            $table->string('transport_type', 50);
            $table->string('request_status', 50);
            $table->string('request_type', 50);
            $table->boolean('hotel_required')->default(false);
            $table->integer('rooms_count')->nullable();
            $table->string('from_location', 100);
            $table->string('to_location', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_requests');
    }
};
