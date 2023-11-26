<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CompanyRateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $company = Company::orderBy(DB::raw('RAND()'))->first();

        return [
            'company_id' => $company->id,
            'shift_type_id' => rand(1, 3),
            'rate' => fake()->randomFloat(2),
            'effective_date' => fake()->date(),
        ];
    }
}
