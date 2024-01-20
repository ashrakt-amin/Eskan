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
        Schema::table('form_sells', function (Blueprint $table) {
            $table->foreignId('sellproject_id')->constrained('sellprojects')->cascadeOnDelete()->cascadeOnUpdate();

        });
    }

    
    public function down(): void
    {
        Schema::table('form_sells', function (Blueprint $table) {
            $table->dropColumn('sellproject_id');

        });
    }
};
