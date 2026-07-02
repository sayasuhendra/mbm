<?php

namespace Tests\Feature;

use App\Filament\Exports\ArcheryParticipantExporter;
use App\Filament\Resources\ArcheryParticipants\Pages\ListArcheryParticipants;
use App\Models\ArcheryParticipant;
use App\Models\User;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
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

    public function test_participant_export_does_not_require_a_queue_worker_by_default(): void
    {
        $export = new Export;
        $exporter = new ArcheryParticipantExporter($export, [], []);

        $this->assertSame('sync', $exporter->getJobConnection());
    }

    public function test_participant_export_finishes_without_a_running_queue_worker(): void
    {
        $permission = Permission::create([
            'name' => 'view participants',
            'guard_name' => 'web',
        ]);

        $user = User::factory()->create();
        $user->givePermissionTo($permission);
        $this->actingAs($user);

        ArcheryParticipant::create([
            'member_number' => 'KPRMBM-202607-0001',
            'parent_name' => 'Wali Peserta',
            'parent_whatsapp' => '628111111111',
            'parent_address' => 'Bandung',
            'child_name' => 'Peserta',
            'child_age' => 12,
            'child_school_class' => 'Kelas 6',
            'training_permission' => true,
            'weekly_donation_amount' => 10000,
            'equipment_option' => 'shared_contribution',
            'status' => ArcheryParticipant::STATUS_ACTIVE,
            'registered_at' => now(),
        ]);

        Livewire::test(ListArcheryParticipants::class)
            ->callAction('exportExcel')
            ->assertHasNoActionErrors();

        $export = Export::query()->latest('id')->firstOrFail();

        $this->assertNotNull($export->completed_at);
        $this->assertSame(1, $export->successful_rows);
        $this->assertSame(0, DB::table('jobs')->count());
    }
}
