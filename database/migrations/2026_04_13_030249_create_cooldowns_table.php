<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    Schema::create('cooldowns', function (Blueprint $table) {
        $table->id();
        $table->foreignId('donor_id')->constrained()->cascadeOnDelete();
        $table->date('last_donation_date');
        $table->date('next_available_date');
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('cooldowns');
    }
};
