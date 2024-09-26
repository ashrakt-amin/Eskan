<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('visitors', function (Blueprint $table) {

            $table->id();
            $table->String('name');
            $table->String('phone');
            $table->String('job');
            $table->String('address');
            $table->String('contact_time');
            $table->text('how');
            $table->text('why');
            $table->String('sales1')->nullable();
            $table->String('sales2')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
