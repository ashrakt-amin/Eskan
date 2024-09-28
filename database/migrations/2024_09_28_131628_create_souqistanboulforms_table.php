<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{


    
    public function up(): void
    {
        Schema::create('souqistanboulforms', function (Blueprint $table) {
            $table->id();
            $table->String('name');
            $table->String('phone');
            $table->String('shop_number');
            $table->String('region');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('souqistanboulforms');
    }
};
