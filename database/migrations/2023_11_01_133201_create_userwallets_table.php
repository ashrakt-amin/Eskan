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
        Schema::create('userwallets', function (Blueprint $table) {
            $table->id();
            $table->String('name');  
            $table->String('phone'); 
            $table->integer('shares_num');
            $table->foreignId('walletunit_id')->constrained('walletunits')->cascadeOnDelete()->cascadeOnUpdate();
            $table->String('feedback')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('userwallets');
    }
};
