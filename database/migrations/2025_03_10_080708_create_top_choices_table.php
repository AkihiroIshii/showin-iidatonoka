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
        Schema::create('top_choices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->string('school_name');
            $table->string('department');
            $table->integer('desired_ranking')->nullable();
            $table->string('selection_method')->nullable();
            $table->date('exam_date')->nullable();
            $table->string('subjects')->nullable();
            $table->date('mock_date')->nullable();
            $table->string('mock_name')->nullable();
            $table->string('mock_judge')->nullable();
            $table->text('memo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('top_choices');
    }
};
