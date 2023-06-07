<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => config('app.user_seeder.name'),
            'email' => config('app.user_seeder.email'),
            'admin' => true,
        ]);

        User::factory(2)->create();
    }
}
