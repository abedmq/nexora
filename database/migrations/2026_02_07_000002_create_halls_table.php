<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('halls', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['meeting_room', 'private_office', 'coworking', 'training_room']);
            $table->integer('capacity');
            $table->decimal('price_per_hour', 10, 2);
            $table->text('amenities')->nullable();
            $table->enum('status', ['available', 'booked', 'maintenance'])->default('available');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('halls');
    }
};
