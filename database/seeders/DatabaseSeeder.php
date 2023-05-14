<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Vladislav Rajtmajer',
            'email' => 'rajtik@gmail.com',
            'admin' => true,
        ]);

        $this->call([
            UserSeeder::class,
            ContractSeeder::class,
            TaskSeeder::class,
            TaskSpentTimeSeeder::class,
            InvoiceSeeder::class,
        ]);
    }
}
