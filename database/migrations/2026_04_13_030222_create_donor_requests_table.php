<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    Schema::create('donor_requests', function (Blueprint $table) {
        $table->id();
        $table->foreignId('created_by')->constrained('users');
        $table->foreignId('blood_type_id')->constrained('blood_types');
        $table->foreignId('location_id')->constrained('locations');
        $table->integer('quantity');
        $table->enum('urgency', ['low', 'medium', 'high']);
        $table->dateTime('deadline');
        $table->enum('status', ['open', 'in_progress', 'closed'])->default('open');
        $table->timestamps();
    });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('donor_requests');
    }
};
