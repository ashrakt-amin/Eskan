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
        Schema::create('city_center_users', function (Blueprint $table) {
            $table->id();
            $table->String('name');
            $table->String('phone');
            $table->String('address');
            $table->String('space');
            $table->String('activity');
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('city_center_users');
    }
};
