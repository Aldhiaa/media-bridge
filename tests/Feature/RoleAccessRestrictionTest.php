<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessRestrictionTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_company_dashboard(): void
    {
        $this->get(route('company.dashboard'))->assertRedirect(route('login'));
    }

    public function test_company_cannot_access_admin_dashboard(): void
    {
        $company = User::factory()->company()->create(['email_verified_at' => now()]);

        $this->actingAs($company)->get(route('admin.dashboard'))->assertForbidden();
    }

    public function test_agency_cannot_access_company_campaign_creation_page(): void
    {
        $agency = User::factory()->agency()->create(['email_verified_at' => now()]);

        $this->actingAs($agency)->get(route('company.campaigns.create'))->assertForbidden();
    }
}
