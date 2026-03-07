<?php

namespace Tests\Feature;

use App\Enums\CampaignStatus;
use App\Models\AgencyProfile;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\CompanyProfile;
use App\Models\Industry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AgencyProposalFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_agency_can_submit_proposal(): void
    {
        $company = User::factory()->company()->create(['email_verified_at' => now()]);
        $agency = User::factory()->agency()->create(['email_verified_at' => now()]);

        CompanyProfile::factory()->for($company, 'user')->create();
        AgencyProfile::factory()->for($agency, 'user')->create();

        $campaign = Campaign::factory()->create([
            'company_id' => $company->id,
            'category_id' => Category::factory()->create()->id,
            'industry_id' => Industry::factory()->create()->id,
            'status' => CampaignStatus::Published->value,
            'proposal_deadline' => now()->addDays(10)->toDateString(),
            'allow_proposal_updates' => true,
        ]);

        $response = $this->actingAs($agency)->post(route('agency.proposals.store', $campaign), [
            'proposed_price' => 2500,
            'strategy_summary' => 'Full-funnel paid campaign and creative plan',
            'execution_timeline' => '30 days',
            'relevant_experience' => 'Worked with similar brands',
            'notes' => 'Can start immediately',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('proposals', [
            'campaign_id' => $campaign->id,
            'agency_id' => $agency->id,
            'proposed_price' => 2500,
        ]);
    }

    public function test_agency_cannot_submit_second_active_proposal_if_updates_disabled(): void
    {
        $company = User::factory()->company()->create(['email_verified_at' => now()]);
        $agency = User::factory()->agency()->create(['email_verified_at' => now()]);
        CompanyProfile::factory()->for($company, 'user')->create();
        AgencyProfile::factory()->for($agency, 'user')->create();

        $campaign = Campaign::factory()->create([
            'company_id' => $company->id,
            'category_id' => Category::factory()->create()->id,
            'industry_id' => Industry::factory()->create()->id,
            'status' => CampaignStatus::Published->value,
            'proposal_deadline' => now()->addDays(10)->toDateString(),
            'allow_proposal_updates' => false,
        ]);

        $payload = [
            'proposed_price' => 2500,
            'strategy_summary' => 'Plan A',
            'execution_timeline' => '20 days',
        ];

        $this->actingAs($agency)->post(route('agency.proposals.store', $campaign), $payload)->assertRedirect();
        $this->actingAs($agency)->post(route('agency.proposals.store', $campaign), $payload)->assertStatus(422);

        $this->assertDatabaseCount('proposals', 1);
    }
}
