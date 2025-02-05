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
        Schema::create('workrecords', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('exam_id')->constrained();
            $table->string('subject');
            $table->string('work_name')->nullable(true);
            $table->string('range')->nullable(true);
            $table->date('date_1st')->nullable(true);
            $table->date('date_2nd')->nullable(true);
            $table->date('date_3rd')->nullable(true);
            $table->text('memo')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workrecords');
    }
};
