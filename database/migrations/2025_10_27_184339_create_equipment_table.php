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
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('type', ['cardio', 'strength', 'flexibility', 'balance', 'mobility', 'other']);
            $table->string('image_url')->nullable();
            $table->string('video_url')->nullable();
            $table->string('serial_number')->unique();
            $table->string('brand');
            $table->string('model');
            $table->enum('status', ['available', 'maintenance', 'out_of_order'])->default('available');
            $table->date('purchased_at');
            $table->decimal('purchase_price', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
