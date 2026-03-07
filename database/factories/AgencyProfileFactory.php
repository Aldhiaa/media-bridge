<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AgencyProfile>
 */
class AgencyProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->agency(),
            'agency_name' => fake()->company().' Media',
            'contact_person' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->numerify('77########'),
            'website' => fake()->optional()->url(),
            'city' => fake()->city(),
            'country' => fake()->country(),
            'about' => fake()->paragraph(),
            'years_experience' => fake()->numberBetween(1, 12),
            'portfolio_links' => [fake()->url(), fake()->url()],
            'minimum_budget' => fake()->numberBetween(500, 4000),
            'team_size' => fake()->randomElement(['1-5', '6-15', '16-30']),
            'pricing_style' => fake()->randomElement(['مشروع ثابت', 'شهري', 'حسب الأداء']),
            'is_complete' => true,
            'is_verified' => fake()->boolean(40),
        ];
    }
}
