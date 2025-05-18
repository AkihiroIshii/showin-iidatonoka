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
        Schema::table('kawaijukuones', function (Blueprint $table) {
            $table->dropColumn('topic');
            $table->integer('num_topic')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kawaijukuones', function (Blueprint $table) {
            $table->string('topic');
            $table->dropColumn('num_topic');
        });
    }
};
