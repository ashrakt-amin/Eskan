<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('souqistanbouls', function (Blueprint $table) {
            $table->id();
            $table->String('name');
            $table->String('phone');
            $table->String('shopnumber');
            $table->String('feedback')->nullable();
            $table->timestamps();
        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('souqistanbouls');
    }
};
