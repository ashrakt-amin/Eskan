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
        Schema::create('real_estate_projects', function (Blueprint $table) {
            $table->id();
            $table->String('name');
            $table->String('img');  
            $table->String('address');   
            $table->integer('resale');  
            $table->String('link')->nullable();
            $table->text('description');
            $table->text('detalis');
            $table->text('features')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('real_estate_projects');
    }
};
