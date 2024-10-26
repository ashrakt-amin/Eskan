<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Http\Controllers\Api\ContactUsController;

return new class extends Migration
{
  
    public function up(): void
    {
        Schema::create('contact_us', function (Blueprint $table) {
            $table->id();
            $table->String('name');
            $table->String('phone');
            $table->String('unit_type');
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('contact_us');
    }
};
