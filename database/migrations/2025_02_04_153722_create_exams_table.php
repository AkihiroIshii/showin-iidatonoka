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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained();
            $table->integer('year');
            $table->string('grade');
            $table->integer('no');
            $table->date('exam_date');
            $table->string('exam_name');
            $table->double('avg_japanese')->nullable(true);
            $table->double('avg_society')->nullable(true);
            $table->double('avg_math')->nullable(true);
            $table->double('avg_science')->nullable(true);
            $table->double('avg_english')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
