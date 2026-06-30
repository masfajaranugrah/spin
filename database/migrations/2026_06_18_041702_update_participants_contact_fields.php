<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            if (! Schema::hasColumn('participants', 'address')) {
                $table->string('address')->default('')->after('name');
            }

            if (! Schema::hasColumn('participants', 'phone_number')) {
                $table->string('phone_number')->default('')->after('address');
            }
        });

        Schema::table('participants', function (Blueprint $table) {
            if (Schema::hasColumn('participants', 'phone_or_id')) {
                $table->dropColumn('phone_or_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            if (! Schema::hasColumn('participants', 'phone_or_id')) {
                $table->string('phone_or_id')->default('')->after('name');
            }
        });

        Schema::table('participants', function (Blueprint $table) {
            if (Schema::hasColumn('participants', 'address')) {
                $table->dropColumn('address');
            }

            if (Schema::hasColumn('participants', 'phone_number')) {
                $table->dropColumn('phone_number');
            }
        });
    }
};
