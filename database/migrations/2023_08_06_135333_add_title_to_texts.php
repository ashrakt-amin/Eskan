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
        Schema::table('texts', function (Blueprint $table) {
            $table->String('title')->nullable();
        });
    }


    public function down(): void
    {
        Schema::table('texts', function (Blueprint $table) {
            $table->dropColumn('title');
        });
    }
};