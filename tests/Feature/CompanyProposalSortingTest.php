<?php

namespace Tests\Feature;

use App\Enums\CampaignStatus;
use App\Models\AgencyProfile;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\CompanyProfile;
use App\Models\Industry;
use App\Models\Proposal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyProposalSortingTest extends TestCase
{
    use RefreshDatabase;

    public function test_company_can_sort_proposals_by_experience_ascending(): void
    {
        [$company, $campaign] = $this->createCompanyAndCampaign();

        $juniorAgency = User::factory()->agency()->create(['email_verified_at' => now()]);
        $seniorAgency = User::factory()->agency()->create(['email_verified_at' => now()]);

        AgencyProfile::factory()->for($juniorAgency, 'user')->create(['years_experience' => 2]);
        AgencyProfile::factory()->for($seniorAgency, 'user')->create(['years_experience' => 10]);

        $seniorProposal = Proposal::factory()->create([
            'campaign_id' => $campaign->id,
            'agency_id' => $seniorAgency->id,
        ]);

        $juniorProposal = Proposal::factory()->create([
            'campaign_id' => $campaign->id,
            'agency_id' => $juniorAgency->id,
        ]);

        $response = $this->actingAs($company)->get(route('company.campaigns.proposals', [
            'campaign' => $campaign,
            'sort' => 'experience',
            'direction' => 'asc',
        ]));

        $response->assertOk();
        $response->assertViewHas('proposals', function ($proposals) use ($juniorProposal, $seniorProposal): bool {
            return $proposals->pluck('id')->values()->all() === [$juniorProposal->id, $seniorProposal->id];
        });
    }

    public function test_company_can_sort_proposals_by_date_in_both_directions(): void
    {
        [$company, $campaign] = $this->createCompanyAndCampaign();

        $agencyA = User::factory()->agency()->create(['email_verified_at' => now()]);
        $agencyB = User::factory()->agency()->create(['email_verified_at' => now()]);

        AgencyProfile::factory()->for($agencyA, 'user')->create();
        AgencyProfile::factory()->for($agencyB, 'user')->create();

        $olderProposal = Proposal::factory()->create([
            'campaign_id' => $campaign->id,
            'agency_id' => $agencyA->id,
            'submitted_at' => now()->subDays(5),
        ]);

        $newerProposal = Proposal::factory()->create([
            'campaign_id' => $campaign->id,
            'agency_id' => $agencyB->id,
            'submitted_at' => now()->subDay(),
        ]);

        $ascResponse = $this->actingAs($company)->get(route('company.campaigns.proposals', [
            'campaign' => $campaign,
            'sort' => 'date',
            'direction' => 'asc',
        ]));

        $ascResponse->assertOk();
        $ascResponse->assertViewHas('proposals', function ($proposals) use ($olderProposal, $newerProposal): bool {
            return $proposals->pluck('id')->values()->all() === [$olderProposal->id, $newerProposal->id];
        });

        $descResponse = $this->actingAs($company)->get(route('company.campaigns.proposals', [
            'campaign' => $campaign,
            'sort' => 'date',
            'direction' => 'desc',
        ]));

        $descResponse->assertOk();
        $descResponse->assertViewHas('proposals', function ($proposals) use ($olderProposal, $newerProposal): bool {
            return $proposals->pluck('id')->values()->all() === [$newerProposal->id, $olderProposal->id];
        });
    }

    /**
     * @return array{0: User, 1: Campaign}
     */
    private function createCompanyAndCampaign(): array
    {
        $company = User::factory()->company()->create(['email_verified_at' => now()]);
        CompanyProfile::factory()->for($company, 'user')->create();

        $campaign = Campaign::factory()->create([
            'company_id' => $company->id,
            'category_id' => Category::factory()->create()->id,
            'industry_id' => Industry::factory()->create()->id,
            'status' => CampaignStatus::UnderReview->value,
            'proposal_deadline' => now()->addDays(3)->toDateString(),
        ]);

        return [$company, $campaign];
    }
}
