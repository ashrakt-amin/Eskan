<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void 

    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->String('name');
            $table->String('phone');
            $table->String('job');
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('unit_id')->nullable()->constrained('units')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
    
};
