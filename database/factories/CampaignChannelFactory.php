<?php

namespace Database\Factories;

use App\Models\Campaign;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CampaignChannel>
 */
class CampaignChannelFactory extends Factory
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
            'channel' => fake()->randomElement([
                'Instagram',
                'TikTok',
                'Snapchat',
                'X',
                'YouTube',
                'Google Ads',
            ]),
        ];
    }
}
