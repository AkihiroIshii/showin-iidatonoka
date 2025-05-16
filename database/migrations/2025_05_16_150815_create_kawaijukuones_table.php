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
        Schema::create('kawaijukuones', function (Blueprint $table) {
            $table->id();
            $table->string('subject_1');
            $table->string('subject_2');
            $table->string('section');
            $table->string('topic');
            $table->string('memo')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kawaijukuones');
    }
};
