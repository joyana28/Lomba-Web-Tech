<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    Schema::create('notifications', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->foreignId('donor_request_id')->constrained()->cascadeOnDelete();
        $table->text('message');
        $table->enum('status', ['sent', 'read'])->default('sent');
        $table->timestamps();
    });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
