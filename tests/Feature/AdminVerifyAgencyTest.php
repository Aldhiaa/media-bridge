<?php

namespace Tests\Feature;

use App\Models\AgencyProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminVerifyAgencyTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_verify_agency_from_user_edit(): void
    {
        $admin = User::factory()->admin()->create();
        $agency = User::factory()->agency()->create();
        $profile = AgencyProfile::factory()->for($agency, 'user')->create(['is_verified' => false]);

        $this->actingAs($admin)->put(route('admin.users.update', $agency), [
            'status' => 'active',
            'role' => 'agency',
            'is_verified' => '1',
        ])->assertRedirect(route('admin.users.index'));

        $this->assertTrue($profile->fresh()->is_verified);
    }
}
