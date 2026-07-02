<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class ArcheryParticipantAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_export_excel_button_is_visible_on_participant_admin_page(): void
    {
        $permission = Permission::create([
            'name' => 'view participants',
            'guard_name' => 'web',
        ]);

        $user = User::factory()->create();
        $user->givePermissionTo($permission);

        $this->actingAs($user)
            ->get('/admin/archery-participants')
            ->assertOk()
            ->assertSee('Export ke Excel');
    }
}
