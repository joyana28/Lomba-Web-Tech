<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    Schema::create('matching_results', function (Blueprint $table) {
        $table->id();
        $table->foreignId('donor_request_id')->constrained()->cascadeOnDelete();
        $table->foreignId('donor_id')->constrained()->cascadeOnDelete();
        $table->double('distance_km')->nullable();
        $table->double('priority_score')->nullable();
        $table->boolean('is_eligible')->default(true);
        $table->timestamps();
    });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('matching_results');
    }
};
