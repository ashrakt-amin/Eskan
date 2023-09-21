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
        Schema::create('bazars', function (Blueprint $table) {
            $table->id();
            $table->String('number');
            $table->decimal('space');
            $table->decimal('meter_price');
            $table->decimal('advance');
            $table->String('installment');
            $table->String('img');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bazars');
    }
};
