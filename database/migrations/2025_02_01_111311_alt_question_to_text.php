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
            $table->text('question')->change();
            $table->text('answer')->change();
            $table->text('reference')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workbooks', function (Blueprint $table) {
            $table->string('question')->change();
            $table->string('answer')->change();
            $table->string('reference')->change();
        });
    }
};
