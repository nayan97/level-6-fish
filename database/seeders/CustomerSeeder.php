<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            ['id' => 1, 'name' => 'জাহিদুল চৌ', 'phone' => null, 'address' => 'চৌ গ্রাম', 'jer' => 963.00, 'created_at' => '2026-01-08 19:54:41', 'updated_at' => '2026-01-08 19:54:41'],
            ['id' => 2, 'name' => 'রুবেল চা', 'phone' => null, 'address' => null, 'jer' => 25382.00, 'created_at' => '2026-01-08 19:55:17', 'updated_at' => '2026-01-08 19:55:17'],
            ['id' => 3, 'name' => 'খোকন কলম', 'phone' => null, 'address' => 'কলম', 'jer' => 5980.00, 'created_at' => '2026-01-08 19:58:32', 'updated_at' => '2026-01-08 19:58:32'],
            ['id' => 4, 'name' => 'পোবাজ', 'phone' => null, 'address' => null, 'jer' => 2560.00, 'created_at' => '2026-01-08 19:59:40', 'updated_at' => '2026-01-08 19:59:40'],
            ['id' => 5, 'name' => 'হাসান নিংইন', 'phone' => null, 'address' => null, 'jer' => 980.00, 'created_at' => '2026-01-08 20:00:21', 'updated_at' => '2026-01-08 20:00:21'],
            ['id' => 21, 'name' => 'রেজা পুঠিমারী', 'phone' => null, 'address' => null, 'jer' => 1010.00, 'created_at' => '2026-01-08 20:01:02', 'updated_at' => '2026-01-08 20:01:02'],
            ['id' => 217, 'name' => 'সজিব মোল্লা', 'phone' => '৫৫', 'address' => null, 'jer' => 0.00, 'created_at' => '2026-01-10 17:49:06', 'updated_at' => '2026-01-10 17:49:06'],
            ['id' => 218, 'name' => 'নাসির আরত', 'phone' => '৫২৫৪', 'address' => null, 'jer' => 0.00, 'created_at' => '2026-01-10 18:42:44', 'updated_at' => '2026-01-10 18:42:44'],
            ['id' => 219, 'name' => 'আওয়াল আরত', 'phone' => '১৫৫', 'address' => null, 'jer' => 0.00, 'created_at' => '2026-01-11 17:43:25', 'updated_at' => '2026-01-11 17:43:25'],
            ['id' => 221, 'name' => 'মাসুদ হাতিয়ান্দহ', 'phone' => null, 'address' => null, 'jer' => 0.00, 'created_at' => '2026-01-11 18:17:18', 'updated_at' => '2026-01-11 18:17:18'],
        ];

        DB::table('customers')->insert($customers);
    }
}