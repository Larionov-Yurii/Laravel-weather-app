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
        Schema::create('forecasts', function (Blueprint $table) {
            $table->id();
            $table->string('city_name');
            $table->integer('timestamp_dt');
            $table->decimal('min_tmp', 5, 2);
            $table->decimal('max_tmp', 5, 2);
            $table->decimal('wind_spd', 5, 2);
            $table->timestamps();
            $table->unique(['city_name', 'timestamp_dt']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forecasts');
    }
};
