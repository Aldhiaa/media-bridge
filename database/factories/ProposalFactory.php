<?php

namespace Database\Factories;

use App\Enums\ProposalStatus;
use App\Models\Campaign;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Proposal>
 */
class ProposalFactory extends Factory
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
            'agency_id' => User::factory()->agency(),
            'proposed_price' => fake()->numberBetween(1000, 20000),
            'strategy_summary' => fake()->paragraph(),
            'execution_timeline' => fake()->randomElement(['15 يوم', '30 يوم', '45 يوم']),
            'relevant_experience' => fake()->paragraph(),
            'notes' => fake()->sentence(),
            'status' => ProposalStatus::Submitted,
            'is_revision' => false,
            'submitted_at' => now(),
        ];
    }
}
