<?php

namespace Tests\Unit;

use App\Models\ArcheryParticipant;
use App\Models\WeeklyDonation;
use App\Services\Donations\WeeklyDonationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WeeklyDonationServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_generates_weekly_donations_for_active_participants_only(): void
    {
        ArcheryParticipant::create($this->participantData('KPRMBM-202606-0001', 'active'));
        ArcheryParticipant::create($this->participantData('KPRMBM-202606-0002', 'inactive'));

        $created = app(WeeklyDonationService::class)->generateForWeek(now()->startOfWeek());

        $this->assertSame(1, $created);
        $this->assertDatabaseCount('weekly_donations', 1);
        $this->assertDatabaseHas('weekly_donations', [
            'amount' => 10000,
            'status' => WeeklyDonation::STATUS_UNPAID,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function participantData(string $memberNumber, string $status): array
    {
        return [
            'member_number' => $memberNumber,
            'parent_name' => 'Wali',
            'parent_whatsapp' => '628111111111',
            'parent_address' => 'Alamat',
            'child_name' => 'Anak',
            'child_age' => 12,
            'child_school_class' => 'Kelas 6',
            'training_permission' => true,
            'weekly_donation_amount' => 10000,
            'equipment_option' => 'shared_contribution',
            'status' => $status,
            'registered_at' => now(),
        ];
    }
}
