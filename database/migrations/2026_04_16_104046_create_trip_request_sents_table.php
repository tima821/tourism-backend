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
        Schema::create('trip_request_sents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')->constrained('trip_requests')->onDelete('cascade');
            $table->foreignId('hotel_id')->nullable()->constrained('hotels');
            $table->foreignId('transport_company_id')->nullable()->constrained('transport_companies');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_request_sents');
    }
};
