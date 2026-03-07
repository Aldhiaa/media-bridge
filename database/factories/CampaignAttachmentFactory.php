<?php

namespace Database\Factories;

use App\Models\Campaign;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CampaignAttachment>
 */
class CampaignAttachmentFactory extends Factory
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
            'uploaded_by' => User::factory()->company(),
            'original_name' => fake()->slug().'.pdf',
            'file_path' => 'campaigns/'.fake()->uuid().'.pdf',
            'mime_type' => 'application/pdf',
            'file_size' => fake()->numberBetween(10_000, 1_500_000),
        ];
    }
}
