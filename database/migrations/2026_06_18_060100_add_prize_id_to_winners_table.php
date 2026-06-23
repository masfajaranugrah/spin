<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('winners', function (Blueprint $table): void {
            $table->foreignId('prize_id')->nullable()->after('participant_id')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('winners', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('prize_id');
        });
    }
};
