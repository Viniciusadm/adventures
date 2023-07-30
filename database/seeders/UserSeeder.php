<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->create([
            'name' => 'Vinícius',
            'email' => 'viniciusam.22@gmail.com',
            'password' => bcrypt('$JeonSomi2'),
            'role' => 'admin',
        ]);

        User::factory()->count(10)->create([
            'role' => 'user'
        ]);
    }
}
