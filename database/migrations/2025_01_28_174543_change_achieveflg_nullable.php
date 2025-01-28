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
        Schema::table('usualtargets', function (Blueprint $table) {
            $table->boolean('achieve_flg')->nullable(true)->change();
            $table->integer('coin')->nullable(true)->change();
            $table->string('comment')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usualtargets', function (Blueprint $table) {
            $table->boolean('achieve_flg')->nullable(false)->change();
            $table->integer('coin')->nullable(false)->change();
            $table->string('comment')->nullable(false)->change();
        });
    }
};
