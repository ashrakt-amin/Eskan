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
        Schema::create('walletunits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('real_estate_project_id')->constrained('real_estate_projects')->cascadeOnDelete()->cascadeOnUpdate();
            $table->String('img');  
            $table->String('num'); 
            $table->integer('shares_num');
            $table->integer('contracted_shares')->nullable(); 
            $table->decimal('share_price',8,3);  
            $table->float('share_meter_num');  
            $table->integer('return'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('walletunits');
    }
};
