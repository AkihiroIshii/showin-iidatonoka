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
        Schema::create('kakugens', function (Blueprint $table) {
            $table->id();
            $table->longtext('sentence');
            $table->string('person');
            $table->string('reference')->nullable(true);
            $table->longtext('comment')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kakugens');
    }
};
