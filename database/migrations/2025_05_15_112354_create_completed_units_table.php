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
        Schema::create('completed_units', function (Blueprint $table) {
            $table->id();
            $table->string('teaching_material');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('unit_id_aishowin')->constrained('aishowins')->cascadeOnDelete();
            $table->integer('num_loop')->nullable(true);
            $table->date('completed_date');
            $table->string('memo')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('completed_units');
    }
};
