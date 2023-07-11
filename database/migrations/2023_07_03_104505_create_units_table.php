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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->String('number');
            $table->decimal('space', 16, 2);
            $table->decimal('meter_price', 16, 2);
            $table->String('advance');
            $table->String('installment');
            $table->String('img');
            $table->String('contract')->nullable();
            $table->integer('rooms');
            $table->String('duration');
            $table->foreignId('level_id')->constrained('levels')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('type_id')->constrained('units_types')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
