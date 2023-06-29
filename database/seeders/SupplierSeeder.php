<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\CompanyDetail;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * For each user create 1 supplier
     */
    public function run(): void
    {
        foreach (User::all() as $user) {
            $companyDetail = CompanyDetail::factory()->create([
                'user_id' => $user->id,
            ]);
            $address = Address::factory()->create([
                'user_id' => $user->id
            ]);

            Supplier::factory()->create([
                'user_id' => $user->id,
                'company_detail_id' => $companyDetail->id,
                'address_id' => $address->id,
                'name' => $user->name,
            ]);
        }
    }
}
