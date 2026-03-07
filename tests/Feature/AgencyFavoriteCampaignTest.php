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

class AgencyFavoriteCampaignTest extends TestCase
{
    use RefreshDatabase;

    public function test_agency_can_favorite_and_unfavorite_campaign(): void
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
        ]);

        $this->actingAs($agency)->post(route('agency.campaigns.favorite', $campaign))->assertRedirect();
        $this->assertDatabaseHas('campaign_favorites', [
            'campaign_id' => $campaign->id,
            'agency_id' => $agency->id,
        ]);

        $this->actingAs($agency)->delete(route('agency.campaigns.unfavorite', $campaign))->assertRedirect();
        $this->assertDatabaseMissing('campaign_favorites', [
            'campaign_id' => $campaign->id,
            'agency_id' => $agency->id,
        ]);
    }
}
