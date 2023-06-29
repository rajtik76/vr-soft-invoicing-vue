<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Address;
use App\Models\BankAccount;
use App\Models\CompanyDetail;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class ContractSeeder extends Seeder
{
    /**
     * For each supplier create 1 contract
     */
    public function run()
    {
        foreach (Supplier::all() as $supplier) {
            $address = Address::factory()->create([
                'user_id' => $supplier->user_id,
            ]);
            $companyDetail = CompanyDetail::factory()->create([
                'user_id' => $supplier->user_id,
            ]);
            $customer = Customer::factory()->create([
                'user_id' => $supplier->user_id,
                'address_id' => $address->id,
                'company_detail_id' => $companyDetail->id,
            ]);
            $bankAccount = BankAccount::factory()->create([
                'user_id' => $supplier->user_id,
            ]);

            Contract::factory()->create([
                'user_id' => $supplier->user_id,
                'supplier_id' => $supplier->id,
                'customer_id' => $customer->id,
                'bank_account_id' => $bankAccount->id,
            ]);
        }
    }
}
