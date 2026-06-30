<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // Menggunakan format data Indonesia

        // 1. Buat Data Akun Admin di tabel `users`
        DB::table('users')->insert([
            'name' => 'Administrator',
            'email' => 'admin@spin.com',
            'password' => Hash::make('password123'), // Password default: password123
            'email_verified_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // 2. Buat 50 Data Dummy Peserta di tabel `participants`
        $participants = [];
        for ($i = 1; $i <= 50; $i++) {
            $participants[] = [
                'id_number' => $faker->unique()->numerify('ID-########'), // Membuat ID unik dengan format ID-8angka
                'name' => $faker->name,
                'address' => $faker->address,
                'phone_number' => $faker->phoneNumber,
                'subscription_fee' => $faker->randomElement([50000, 75000, 100000, 150000, 200000]), // Acak biaya langganan
                'created_at' => Carbon::now()->subDays(rand(1, 30)),
                'updated_at' => Carbon::now(),
            ];
        }
        DB::table('participants')->insert($participants);

        // 3. Masukkan Data Hadiah di tabel `prizes` (jika tabel masih kosong)
        if (DB::table('prizes')->count() == 0) {
            DB::table('prizes')->insert([
                [
                    'name' => 'Tiket ke Bromo', 'category' => 'Travel & Wisata',
                    'quota' => 4, 'remaining' => 2, 'priority' => 1, 'is_active' => 1,
                    'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAN-a39dGIdZL8fgaEYXiENXNF6ZDoW99wPwO1eYXjBupsvxlHtjPqreJNt1G5bcrUqODHabD6WpisQIxNEbRwJsaJV_hQpxcP4fVwOr4U-QeNceO4GsWcuhp8EHSR32bszZ7zfR1m76Kw4N67iNk8DRwi-fvH70g8Zmk6lRaUCAbACFFI0Tt_Lk7tkPf0uL4h-kXt-EYon8MvcNzFrB4qhQEgDfjc1S37r_D4Qs7a8kCGc5J8evZFxM2s-T7te0dh3SkH47kw715tT',
                    'created_at' => Carbon::now(), 'updated_at' => Carbon::now()
                ],
                [
                    'name' => 'iPhone 15 Pro', 'category' => 'Elektronik',
                    'quota' => 1, 'remaining' => 0, 'priority' => 2, 'is_active' => 1,
                    'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBbCLzMU4GGf_J8J2tHHS6oxC-BEIqNDktpK6uCr3qeWxX6Lf3Liyc1kPpEKBEVJyfT0WBK7SQ2LrzhBLdVMsaaO74UcVKDBUXrTxWlUvRgQ6mVtugOFJthESQgz_meVDi4srtlJqu3gklLusNe7uQ_GBfq-ozVx_iPetEqiSmTs9GGyKYrZ6pS2qdx5nsggoh95a3zHiuUOer_lsHSP-7QfFR1AWJ27pJAN_mKZsrdiD5etXLb_OJ9AU_6_3bineT6uNx0ubA_VfR5',
                    'created_at' => Carbon::now(), 'updated_at' => Carbon::now()
                ],
                [
                    'name' => 'Gaming Gear Set', 'category' => 'Elektronik',
                    'quota' => 5, 'remaining' => 5, 'priority' => 3, 'is_active' => 1,
                    'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAOlhXW4WfWiHIhpjb-YpeU8jqxBCkhQ9I_YCs_fA0pFmzW9_mCgv-eAhkJDY7J8WSRKHZQvCGppPpruUvEENq6WgDvdcuwnyTbcCTx-JdPdE06PQE03pSd0tssCn-Z9peMtE8FYaMoSlKwwQcIP7nuQ7HusNXh7RoWrvzkFlRBhgh5hOEneYMnqk7baxBmWG7tvqSJbjPVq-00162ZkBVZbRjR2jJXggeKXYL91gYNwh5oF9FOwcQ8uqnqx8bSb1FtfT4uVzxXDEDo',
                    'created_at' => Carbon::now(), 'updated_at' => Carbon::now()
                ]
            ]);
        }

        // 4. Buat 5 Data Dummy Pemenang di tabel `winners`
        $winners = [];
        for ($i = 1; $i <= 5; $i++) {
            $winners[] = [
                'participant_id' => rand(1, 50), // Mengambil ID peserta acak 1-50
                'prize_id' => rand(1, 3),        // Mengambil ID hadiah acak 1-3
                'giveaway_name' => 'Grand Launching Giveaway',
                'prize_name' => 'Hadiah Misteri ' . $i,
                'drawn_at' => Carbon::now()->subHours(rand(1, 24)),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }
        DB::table('winners')->insert($winners);
    }
}
