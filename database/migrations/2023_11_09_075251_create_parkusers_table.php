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
        Schema::create('parkusers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete()->cascadeOnUpdate();
            $table->String('name');
            $table->String('phone');
            $table->String('job')->nullable();
            $table->String('national_ID')->nullable();
            $table->String('space')->nullable();
            $table->String('products_type')->nullable();
            $table->String('feedback')->nullable();
            $table->String('type');
            $table->softDeletes();



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parkusers');
    }
};
