<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('owners', function (Blueprint $table) {
            $table->id();
            $table->String('name');
            $table->String('phone');
            $table->String('job')->nullable;
            $table->String('address')->nullable;
            $table->String('unit_type')->nullable;
            $table->String('price')->nullable;
            $table->String('premium');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('owners');
    }
};
