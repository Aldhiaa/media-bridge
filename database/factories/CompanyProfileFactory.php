<?php

namespace Database\Factories;

use App\Models\Industry;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CompanyProfile>
 */
class CompanyProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->company(),
            'company_name' => fake()->company().' LLC',
            'brand_name' => fake()->companySuffix(),
            'contact_person' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->numerify('77########'),
            'website' => fake()->optional()->url(),
            'industry_id' => Industry::factory(),
            'city' => fake()->city(),
            'country' => fake()->country(),
            'description' => fake()->paragraph(),
            'is_complete' => true,
        ];
    }
}
