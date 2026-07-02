<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@teste.com',
            'password' => bcrypt('admin123'),
        ]);

        $this->call([
            BookSeeder::class,
        ]);
    }
}