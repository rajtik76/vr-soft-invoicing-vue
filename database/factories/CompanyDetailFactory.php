<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\CompanyDetail;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CompanyDetail>
 */
class CompanyDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'vat_number' => fake()->randomNumber(9, true),
            'registration_number' => fake()->randomNumber(9, true),
            'mobile' => fake()->phoneNumber(),
            'email' => fake()->companyEmail(),
        ];
    }
}
