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
        Schema::create('aishowins', function (Blueprint $table) {
            $table->id();
            $table->string('grade');
            $table->string('subject');
            $table->string('main_category')->nullable(true);
            $table->string('sub_category')->nullable(true);
            $table->integer('sub_category_order')->nullable(true);
            $table->string('unit');
            $table->string('explanation')->nullable(true);
            $table->string('new_word')->nullable(true);
            $table->integer('num_level')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aishowins');
    }
};
