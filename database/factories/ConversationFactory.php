<?php

namespace Database\Factories;

use App\Models\Campaign;
use App\Models\Proposal;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Conversation>
 */
class ConversationFactory extends Factory
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
            'last_message_at' => now(),
        ];
    }
}
