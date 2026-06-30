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
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->string('id_number')->unique(); // Tambahan: Nomor ID
            $table->string('name');
            $table->string('address');
            $table->string('phone_number');
            $table->integer('subscription_fee')->default(0); // Tambahan: Biaya Langganan
            $table->timestamps();

            // Indexing untuk mempercepat pencarian data
            $table->index('id_number');
            $table->index('name');
            $table->index('phone_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};
