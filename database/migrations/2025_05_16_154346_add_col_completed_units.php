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
        Schema::table('completed_units', function (Blueprint $table) {
            $table->dropForeign('completed_units_unit_id_aishowin_foreign');
            $table->foreignId('unit_id_aishowin')->nullable(true)->change();
            $table->foreign('unit_id_aishowin')->references('id')->on('aishowins')->onDelete('cascade');
            $table->foreignId('unit_id_mojizou')->nullable(true);
            $table->foreign('unit_id_mojizou')->references('id')->on('mojizous')->onDelete('cascade');
            $table->foreignId('unit_id_kawaijukuone')->nullable(true);
            $table->foreign('unit_id_kawaijukuone')->references('id')->on('kawaijukuones')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('completed_units', function (Blueprint $table) {
            $table->dropForeign('completed_units_unit_id_aishowin_foreign');
            $table->foreignId('unit_id_aishowin')->nullable(false)->change();
            $table->foreign('unit_id_aishowin')->references('id')->on('aishowins')->onDelete('cascade');
            $table->dropForeign('completed_units_unit_id_mojizou_foreign');
            $table->dropColomns('unit_id_mojizou');
            $table->dropForeign('completed_units_unit_id_kawaijukuone_foreign');
            $table->dropColomns('unit_id_kawaijukuone');
        });
    }
};
