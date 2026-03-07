<?php

namespace Database\Factories;

use App\Models\Proposal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProposalAttachment>
 */
class ProposalAttachmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'proposal_id' => Proposal::factory(),
            'original_name' => fake()->slug().'.pdf',
            'file_path' => 'proposals/'.fake()->uuid().'.pdf',
            'mime_type' => 'application/pdf',
            'file_size' => fake()->numberBetween(10_000, 1_500_000),
        ];
    }
}
