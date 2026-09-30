<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Database\Seeders\CashesTableSeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

     protected static ?string $password;
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            CashesTableSeeder::class,
            CustomerSeeder::class,
            ProductSeeder::class,
            MohajonSeeder::class,
        ]);

        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'remember_token' => Str::random(10),
        ]);

        $admin->assignRole('admin');
    }
}
