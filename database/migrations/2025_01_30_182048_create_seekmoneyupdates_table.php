<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {

        Schema::create('seekmoneyupdates', function (Blueprint $table) {
        $table->id();
        $table->String('name');
        $table->String('phone');
        $table->enum('type',['تجارى','سكنى']);
        $table->String('space');
        $table->String('advance');
        $table->String('installment');
        $table->String('responsible');
        $table->String('feedback')->nullable();
        $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seekmoneyupdates');
    }
};
