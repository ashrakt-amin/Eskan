<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::table('bazars', function (Blueprint $table) {
            $table->boolean('appear')->default(1);

        });
    }

  
    public function down(): void
    {
        Schema::table('bazars', function (Blueprint $table) {
            $table->dropColumn('appear');

        });
    }
};