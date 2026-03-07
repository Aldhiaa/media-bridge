<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\CompanyProfile;
use App\Models\Industry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyCampaignFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_company_can_create_campaign(): void
    {
        $company = User::factory()->company()->create([
            'email_verified_at' => now(),
        ]);

        CompanyProfile::factory()->for($company, 'user')->create();

        $category = Category::factory()->create();
        $industry = Industry::factory()->create();

        $response = $this->actingAs($company)->post(route('company.campaigns.store'), [
            'title' => 'Launch Ramadan Offer',
            'category_id' => $category->id,
            'industry_id' => $industry->id,
            'objective' => 'Brand awareness',
            'description' => 'A detailed brief for the campaign.',
            'target_audience' => 'Young adults in major cities',
            'channels' => ['Instagram', 'TikTok'],
            'required_deliverables' => '10 posts and 4 short videos',
            'budget' => 3000,
            'start_date' => now()->addDays(5)->toDateString(),
            'end_date' => now()->addDays(35)->toDateString(),
            'proposal_deadline' => now()->addDays(3)->toDateString(),
            'allow_proposal_updates' => true,
            'status' => 'published',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('campaigns', [
            'company_id' => $company->id,
            'title' => 'Launch Ramadan Offer',
        ]);
        $this->assertDatabaseCount('campaign_channels', 2);
    }
}
