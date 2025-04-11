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
        Schema::table('links', function (Blueprint $table) {
            $table->string('admin_link')->nullable(true)->change();
            $table->string('grade')->nullable(true)->change();
            $table->string('memo')->nullable(true)->change();
            $table->string('category')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('links', function (Blueprint $table) {
            $table->string('admin_link')->nullable(false)->change();
            $table->string('grade')->nullable(false)->change();
            $table->string('memo')->nullable(false)->change();
            $table->dropColomns('category');
        });
    }
};
