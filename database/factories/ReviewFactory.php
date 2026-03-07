<?php

namespace Database\Factories;

use App\Models\Campaign;
use App\Models\Proposal;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'campaign_id' => Campaign::factory(),
            'proposal_id' => Proposal::factory(),
            'company_id' => User::factory()->company(),
            'agency_id' => User::factory()->agency(),
            'rating' => fake()->numberBetween(3, 5),
            'comment' => fake()->sentence(),
            'is_approved' => true,
        ];
    }
}
