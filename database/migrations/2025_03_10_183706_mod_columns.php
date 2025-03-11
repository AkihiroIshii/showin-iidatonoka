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
            $table->renameColumn('1st_date', 'first_date');
            $table->renameColumn('2nd_date', 'second_date');
            $table->renameColumn('1st_score', 'first_score');
            $table->renameColumn('2nd_score', 'second_score');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kenteis', function (Blueprint $table) {
            $table->renameColumn('first_date', '1st_date');
            $table->renameColumn('second_date', '2nd_date');
            $table->renameColumn('first_score', '1st_score');
            $table->renameColumn('second_score', '2nd_score');
        });
    }
};
