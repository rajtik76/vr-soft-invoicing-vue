<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Address;
use App\Models\CompanyDetail;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'company_detail_id' => CompanyDetail::factory(),
            'address_id' => Address::factory(),
            'name' => fake()->company(),
        ];
    }
}
