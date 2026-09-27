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
        Schema::table('workbooks', function (Blueprint $table) {
            $table->foreignId('campus_id')->nullable()->constrained('campuses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workbooks', function (Blueprint $table) {
            $table->dropColumn('campus_id');
        });
    }
};
