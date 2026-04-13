<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    Schema::create('locations', function (Blueprint $table) {
        $table->id();
        $table->double('latitude');
        $table->double('longitude');
        $table->text('address')->nullable();
    });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
