<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  

    public function up(): void
    {
        Schema::table('seek_money', function (Blueprint $table) {
            $table->String('feedback')->nullable();
        });
    }

   

    public function down(): void
    {
        Schema::table('seek_money', function (Blueprint $table) {
            $table->dropColumn('feedback');
        });
    }
};
