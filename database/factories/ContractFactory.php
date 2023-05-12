<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\BankAccount;
use App\Models\Customer;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contract>
 */
class ContractFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'supplier_id' => Supplier::factory(),
            'customer_id' => Customer::factory(),
            'bank_account_id' => BankAccount::factory(),
            'number' => fake()->slug(),
            'signed_at' => fake()->date(),
            'price_per_unit' => fake()->randomFloat(1, 10, 50),
        ];
    }
}
