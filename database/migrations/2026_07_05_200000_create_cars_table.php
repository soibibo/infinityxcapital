<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('name');
            $table->string('desc')->nullable();
            $table->string('fee');
            $table->string('image')->nullable();
            $table->string('category')->nullable();
            $table->string('badge')->nullable();
            $table->string('power')->nullable();
            $table->string('range')->nullable();
            $table->string('delivery')->nullable();
            $table->string('gradient')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
