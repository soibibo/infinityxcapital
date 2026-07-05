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
        Schema::create('giveaway_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 255);
            $table->string('email', 255);
            $table->string('phone', 20);
            $table->string('car_model', 50);
            $table->string('car_name', 255);
            $table->string('car_fee', 20);
            $table->string('street', 255);
            $table->string('city', 255);
            $table->string('zip', 20);
            $table->string('country', 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('giveaway_submissions');
    }
};
