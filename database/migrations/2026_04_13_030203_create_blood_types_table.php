<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    Schema::create('blood_types', function (Blueprint $table) {
        $table->id();
        $table->string('type', 5);
        $table->enum('rhesus', ['+', '-'])->default('+');
    });
    }

    public function down(): void
    {
        Schema::dropIfExists('blood_types');
    }
};
