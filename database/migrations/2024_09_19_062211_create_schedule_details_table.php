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
        Schema::create('schedule_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->references('id')->on('schedules')->onDelete('cascade');
            // $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->date('date');
            $table->string('shift');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_details');
    }
};
