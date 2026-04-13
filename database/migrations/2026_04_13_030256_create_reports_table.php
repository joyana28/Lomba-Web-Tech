<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {   
    Schema::create('reports', function (Blueprint $table) {
        $table->id();
        $table->integer('total_requests')->default(0);
        $table->integer('total_donors')->default(0);
        $table->double('success_rate')->default(0);
        $table->timestamps();
    });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
