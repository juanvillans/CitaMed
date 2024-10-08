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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('specialty_id');
            $table->string('title',50);
            $table->json('availability_json');
            $table->json('adjust_avability_json');
            $table->json('programming_slot_json');
            $table->json('booked_appointment_settings_json');
            $table->string('description',255);
            $table->json('fields_json');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
