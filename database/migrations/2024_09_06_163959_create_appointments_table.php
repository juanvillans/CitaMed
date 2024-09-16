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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id');
            $table->string('title',50);
            $table->integer('duration_per_appointment');
            $table->json('schedule_json');
            $table->date('start_date_agenda');
            $table->date('end_date_agenda')->nullable();
            $table->integer('max_reservation_time_before_appointment')->default(0);
            $table->integer('min_reservation_time_before_appointment')->default(0);
            $table->json('adjust_avability_json');
            $table->integer('duration_between_appointmen');
            $table->integer('max_reservations_per_day');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
