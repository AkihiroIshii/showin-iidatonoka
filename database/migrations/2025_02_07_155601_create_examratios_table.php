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
        Schema::create('examratios', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->foreignId('school_id')->constrained();
            $table->string('department');
            $table->string('type');
            $table->string('period');
            $table->integer('num_capacity');
            $table->integer('num_applicants');
            $table->integer('num_examinees')->nullable(true);
            $table->integer('num_passed')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examratios');
    }
};
