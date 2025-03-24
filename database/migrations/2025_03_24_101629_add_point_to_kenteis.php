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
        Schema::table('kenteis', function (Blueprint $table) {
            $table->integer('first_point')->nullable(true);
            $table->integer('second_point')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kenteis', function (Blueprint $table) {
            $table->dropColomns('first_point');
            $table->dropColomns('second_point');
        });
    }
};
