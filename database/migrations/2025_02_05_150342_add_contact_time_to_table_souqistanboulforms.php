<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::table('souqistanboulforms', function (Blueprint $table) {
            $table->String('contact_time')->after('shop_number');
        });
    }

   
    public function down(): void
    {
        Schema::table('souqistanboulforms', function (Blueprint $table) {
            $table->dropColumn('contact_time');
        });
    }
};
