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
            $table->string('subject_id')->nullable(true);
            $table->integer('term')->nullable(true);
            $table->longtext('explanation')->nullable(true);
            $table->string('unit')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workbooks', function (Blueprint $table) {
            $table->dropColumn('subject_id');
            $table->dropColumn('term');
            $table->dropColumn('explanation');
            $table->dropColumn('unit');
        });
    }
};
