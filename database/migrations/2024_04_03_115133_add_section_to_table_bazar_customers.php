<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bazar_customers', function (Blueprint $table) {
            $table->String('section')->nullable();
        });
    }


    public function down(): void
    {
        Schema::table('bazar_customers', function (Blueprint $table) {
            $table->dropColumn('section');
        });
    }
};
