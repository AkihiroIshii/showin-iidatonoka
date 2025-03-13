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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->date('day_of_absence_1');
            $table->date('day_of_absence_2')->nullable();
            $table->date('day_of_absence_3')->nullable();
            $table->time('time_from_absence_1');
            $table->time('time_from_absence_2')->nullable();
            $table->time('time_from_absence_3')->nullable();
            $table->time('time_to_absence_1');
            $table->time('time_to_absence_2')->nullable();
            $table->time('time_to_absence_3')->nullable();
            $table->string('reason_of_absence_1');
            $table->string('reason_of_absence_2')->nullable();
            $table->string('reason_of_absence_3')->nullable();
            $table->date('alternative_day_1');
            $table->date('alternative_day_2')->nullable();
            $table->date('alternative_day_3')->nullable();
            $table->time('time_from_alternative_1');
            $table->time('time_from_alternative_2')->nullable();
            $table->time('time_from_alternative_3')->nullable();
            $table->time('time_to_alternative_1');
            $table->time('time_to_alternative_2')->nullable();
            $table->time('time_to_alternative_3')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
