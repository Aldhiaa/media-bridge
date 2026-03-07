<?php

namespace Database\Factories;

use App\Enums\CampaignStatus;
use App\Models\Category;
use App\Models\Industry;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Campaign>
 */
class CampaignFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $proposalDeadline = fake()->dateTimeBetween('now', '+30 days');

        return [
            'company_id' => User::factory()->company(),
            'category_id' => Category::factory(),
            'industry_id' => Industry::factory(),
            'title' => fake()->sentence(4),
            'objective' => fake()->randomElement([
                'زيادة الوعي بالعلامة التجارية',
                'رفع المبيعات',
                'توليد عملاء محتملين',
                'إطلاق منتج جديد',
            ]),
            'description' => fake()->paragraphs(2, true),
            'target_audience' => fake()->sentence(8),
            'required_deliverables' => fake()->sentence(10),
            'budget' => fake()->numberBetween(1000, 20000),
            'start_date' => fake()->dateTimeBetween('+5 days', '+45 days'),
            'end_date' => fake()->dateTimeBetween('+46 days', '+90 days'),
            'proposal_deadline' => $proposalDeadline,
            'allow_proposal_updates' => true,
            'status' => fake()->randomElement([
                CampaignStatus::Published,
                CampaignStatus::ReceivingProposals,
                CampaignStatus::UnderReview,
            ]),
            'is_featured' => fake()->boolean(20),
            'published_at' => fake()->dateTimeBetween('-20 days', 'now'),
        ];
    }
}
