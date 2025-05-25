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
        Schema::create('entrance_exam_data_highschools', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->string('department');
            $table->string('department_short');
            $table->string('early_capacity')->nullable(true);
            $table->string('early_survey1_applicants')->nullable(true);
            $table->string('early_survey2_applicants')->nullable(true);
            $table->string('early_applicants')->nullable(true);
            $table->string('early_taker')->nullable(true);
            $table->string('early_passed')->nullable(true);
            $table->string('early_admission')->nullable(true);
            $table->string('late_capacity')->nullable(true);
            $table->string('late_survey1_applicants')->nullable(true);
            $table->string('late_survey2_applicants')->nullable(true);
            $table->string('late_pre_applicants')->nullable(true);
            $table->string('late_post_applicants')->nullable(true);
            $table->string('late_taker')->nullable(true);
            $table->string('late_passed')->nullable(true);
            $table->string('late_admission')->nullable(true);
            $table->string('rerecruitment')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entrance_exam_data_highschools');
    }
};
