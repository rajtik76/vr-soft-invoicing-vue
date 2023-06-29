<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\BankAccount;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\Enums\BankAccountCurrencyEnum;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Contract>
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
            'user_id' => User::factory(),
            'supplier_id' => Supplier::factory(),
            'customer_id' => Customer::factory(),
            'bank_account_id' => BankAccount::factory(),
            'number' => fake()->creditCardNumber(),
            'signed_at' => fake()->date(),
            'price_per_unit' => function (array $attributes) {
                $bankAccount = BankAccount::findOrFail($attributes['bank_account_id']);

                return match ($bankAccount->currency) {
                    BankAccountCurrencyEnum::CZK => fake()->randomFloat(1, 500, 1500),
                    default => fake()->randomFloat(1, 10, 50),
                };
            },
        ];
    }
}
