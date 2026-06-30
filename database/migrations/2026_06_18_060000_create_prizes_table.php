<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prizes', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('category')->default('Umum');
            $table->unsignedInteger('quota')->default(1);
            $table->unsignedInteger('remaining')->default(1);
            $table->unsignedInteger('priority')->default(0);
            $table->text('image_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'remaining', 'priority']);
        });

        DB::table('prizes')->insert([
            [
                'name' => 'Tiket ke Bromo',
                'category' => 'Travel & Wisata',
                'quota' => 4,
                'remaining' => 2,
                'priority' => 1,
                'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAN-a39dGIdZL8fgaEYXiENXNF6ZDoW99wPwO1eYXjBupsvxlHtjPqreJNt1G5bcrUqODHabD6WpisQIxNEbRwJsaJV_hQpxcP4fVwOr4U-QeNceO4GsWcuhp8EHSR32bszZ7zfR1m76Kw4N67iNk8DRwi-fvH70g8Zmk6lRaUCAbACFFI0Tt_Lk7tkPf0uL4h-kXt-EYon8MvcNzFrB4qhQEgDfjc1S37r_D4Qs7a8kCGc5J8evZFxM2s-T7te0dh3SkH47kw715tT',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'iPhone 15 Pro',
                'category' => 'Elektronik',
                'quota' => 1,
                'remaining' => 0,
                'priority' => 2,
                'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBbCLzMU4GGf_J8J2tHHS6oxC-BEIqNDktpK6uCr3qeWxX6Lf3Liyc1kPpEKBEVJyfT0WBK7SQ2LrzhBLdVMsaaO74UcVKDBUXrTxWlUvRgQ6mVtugOFJthESQgz_meVDi4srtlJqu3gklLusNe7uQ_GBfq-ozVx_iPetEqiSmTs9GGyKYrZ6pS2qdx5nsggoh95a3zHiuUOer_lsHSP-7QfFR1AWJ27pJAN_mKZsrdiD5etXLb_OJ9AU_6_3bineT6uNx0ubA_VfR5',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gaming Gear Set',
                'category' => 'Elektronik',
                'quota' => 5,
                'remaining' => 5,
                'priority' => 3,
                'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAOlhXW4WfWiHIhpjb-YpeU8jqxBCkhQ9I_YCs_fA0pFmzW9_mCgv-eAhkJDY7J8WSRKHZQvCGppPpruUvEENq6WgDvdcuwnyTbcCTx-JdPdE06PQE03pSd0tssCn-Z9peMtE8FYaMoSlKwwQcIP7nuQ7HusNXh7RoWrvzkFlRBhgh5hOEneYMnqk7baxBmWG7tvqSJbjPVq-00162ZkBVZbRjR2jJXggeKXYL91gYNwh5oF9FOwcQ8uqnqx8bSb1FtfT4uVzxXDEDo',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Premium Coffee Sub',
                'category' => 'Voucher',
                'quota' => 20,
                'remaining' => 12,
                'priority' => 4,
                'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDJStLkj7YoHZfkNZ0RZPd0S3BhXwuRyEhMVxf7J4xnQ7TksbiZmirw-v-WqZsOjvVex2Mz7zWZMDAepncIoeG_FiK9Z1cAxI4uFa_bRs5KEDS39XZ6t1C0ofFXyIfRXtNrRQ_afNJTFYQftgYw48T8N_Segyi0zcOOmGq8RsctoDbnDM8_vyWY4RfDyu4dKRCkW4sE7gBvE8dL-zFMMoIvhHn9J1mCabA9rQ4BaHs7-kzWqn0PJDk9j_0TpN3_z1pulS1iond4GCGB',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('prizes');
    }
};
