<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Contract;
use App\Models\Enums\BankAccountCurrencyEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $date = Carbon::parse(fake()->unique()->date());

        $contentArray = [];
        for ($i = 0; $i < fake()->numberBetween(10, 20); $i++) {
            $contentArray[] = [
                'name' => 'WW-'.fake()->randomNumber(6, true).' '.fake()->unique()->slug,
                'url' => fake()->boolean() ? fake()->url() : null,
                'hours' => fake()->randomFloat(1, 10, 50),
            ];
        }

        return [
            'contract_id' => Contract::factory(),
            'number' => $date->year.sprintf('%02d', $date->month).fake()->unique()->randomNumber(3, true),
            'year' => $date->year,
            'month' => $date->month,
            'issue_date' => fake()->date(),
            'due_date' => fake()->date(),
            'content' => $contentArray,
            'price_per_unit' => fake()->randomFloat(2, 10, 50),
            'total_amount' => fake()->randomFloat(1, 500, 7500),
            'currency' => fake()->randomElement(BankAccountCurrencyEnum::cases()),
        ];
    }
}
