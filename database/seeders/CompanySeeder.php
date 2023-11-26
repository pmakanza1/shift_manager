<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\CompanyRate;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::factory()->count(5)->has(CompanyRate::factory()->count(3))->create();
    }
}
