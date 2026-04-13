<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    Schema::create('donation_histories', function (Blueprint $table) {
        $table->id();
        $table->foreignId('donor_id')->constrained()->cascadeOnDelete();
        $table->foreignId('donor_request_id')->constrained()->cascadeOnDelete();
        $table->date('donation_date');
        $table->enum('status', ['completed', 'cancelled']);
        $table->timestamps();
    });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('donation_histories');
    }
};
