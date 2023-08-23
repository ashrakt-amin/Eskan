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
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->String('name');
            $table->String('job');
            $table->String('address');
            $table->String('phone');
            $table->String('whats');
            $table->String('join_reason');
            $table->String('average_money');
            $table->String('installement');
            $table->String('feedback')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

  
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
