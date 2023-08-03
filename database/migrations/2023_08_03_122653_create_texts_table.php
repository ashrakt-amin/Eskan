<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('texts', function (Blueprint $table) {
            $table->id();
            $table->String('name');
            $table->text('description');
            $table->timestamps();
        });
    }
    

    public function down(): void
    {
        Schema::dropIfExists('texts');
    }
};
