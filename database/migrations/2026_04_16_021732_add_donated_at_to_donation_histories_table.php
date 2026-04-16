<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('donation_histories', 'donated_at')) {
            Schema::table('donation_histories', function (Blueprint $table) {
                $table->timestamp('donated_at')->nullable()->after('notes');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('donation_histories', 'donated_at')) {
            Schema::table('donation_histories', function (Blueprint $table) {
                $table->dropColumn('donated_at');
            });
        }
    }
};