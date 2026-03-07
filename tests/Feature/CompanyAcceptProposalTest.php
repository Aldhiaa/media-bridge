<?php

namespace Tests\Feature;

use App\Enums\CampaignStatus;
use App\Enums\ProposalStatus;
use App\Models\AgencyProfile;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\CompanyProfile;
use App\Models\Industry;
use App\Models\Proposal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyAcceptProposalTest extends TestCase
{
    use RefreshDatabase;

    public function test_company_can_accept_one_proposal_and_reject_others(): void
    {
        $company = User::factory()->company()->create(['email_verified_at' => now()]);
        $agencyA = User::factory()->agency()->create(['email_verified_at' => now()]);
        $agencyB = User::factory()->agency()->create(['email_verified_at' => now()]);

        CompanyProfile::factory()->for($company, 'user')->create();
        AgencyProfile::factory()->for($agencyA, 'user')->create();
        AgencyProfile::factory()->for($agencyB, 'user')->create();

        $campaign = Campaign::factory()->create([
            'company_id' => $company->id,
            'category_id' => Category::factory()->create()->id,
            'industry_id' => Industry::factory()->create()->id,
            'status' => CampaignStatus::UnderReview->value,
            'proposal_deadline' => now()->addDays(3)->toDateString(),
        ]);

        $proposalA = Proposal::factory()->create([
            'campaign_id' => $campaign->id,
            'agency_id' => $agencyA->id,
            'status' => ProposalStatus::Submitted->value,
        ]);
        $proposalB = Proposal::factory()->create([
            'campaign_id' => $campaign->id,
            'agency_id' => $agencyB->id,
            'status' => ProposalStatus::Submitted->value,
        ]);

        $this->actingAs($company)->post(route('company.proposals.accept', $proposalA))->assertRedirect();

        $this->assertDatabaseHas('proposals', [
            'id' => $proposalA->id,
            'status' => ProposalStatus::Accepted->value,
        ]);
        $this->assertDatabaseHas('proposals', [
            'id' => $proposalB->id,
            'status' => ProposalStatus::Rejected->value,
        ]);
        $this->assertDatabaseHas('campaigns', [
            'id' => $campaign->id,
            'status' => CampaignStatus::Awarded->value,
        ]);
    }
}
