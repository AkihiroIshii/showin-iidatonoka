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
        Schema::create('mojizous', function (Blueprint $table) {
            $table->id();
            $table->string('grade');
            $table->string('category');
            $table->string('topic');
            $table->integer('num_question');
            $table->string('memo')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mojizous');
    }
};
