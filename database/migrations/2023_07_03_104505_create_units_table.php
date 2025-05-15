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
            $table->integer('advance_rate');
            $table->decimal('advance')->nullable();
            $table->String('installment');
            $table->String('contract')->nullable();
            $table->integer('rooms')->nullable();
            $table->String('duration');
            $table->foreignId('level_id')->constrained('levels')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('type_id')->constrained('units_types')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete()->cascadeOnUpdate();
            $table->String('levelimg')->nullable();
            $table->String('step')->nullable();
            $table->decimal('receiving')->nullable();
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
