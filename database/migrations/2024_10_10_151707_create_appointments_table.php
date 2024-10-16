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
            $table->foreignId('service_id');
            $table->string('name');
            $table->string('last_name');
            $table->string('ci');
            $table->string('phone');
            $table->string('email');
            $table->json('other_fields');
            $table->time('start');
            $table->time('end');
            $table->string('date');
            $table->string('status');
            $table->date('carbon_date');
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
