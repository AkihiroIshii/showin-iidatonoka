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
        Schema::table('workrecords', function (Blueprint $table) {
            $table->renameColumn('range', 'work_range');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workrecords', function (Blueprint $table) {
            $table->renameColumn('work_range', 'range');
        });
    }
};
