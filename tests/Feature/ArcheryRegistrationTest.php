<?php

namespace Tests\Feature;

use App\Models\ArcheryParticipant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArcheryRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_registration_creates_pending_participant(): void
    {
        $response = $this->post(route('archery.registration.store'), [
            'parent_name' => 'Ahmad Fauzi',
            'parent_whatsapp' => '628111111111',
            'parent_address' => 'Dekat Masjid Baitul Muttaqin',
            'child_name' => 'Ibrahim Fauzi',
            'child_age' => 12,
            'child_school_class' => 'Kelas 6 SDIT',
            'training_permission' => true,
            'weekly_donation_choice' => 'other',
            'weekly_donation_other' => 20000,
            'equipment_option' => 'shared_contribution',
            'suggestion' => 'Semoga rutin.',
        ]);

        $response->assertRedirect(route('archery.registration.create'));

        $this->assertDatabaseHas('archery_participants', [
            'parent_name' => 'Ahmad Fauzi',
            'child_name' => 'Ibrahim Fauzi',
            'weekly_donation_amount' => 20000,
            'status' => ArcheryParticipant::STATUS_PENDING,
        ]);
    }

    public function test_public_competition_registration_creates_pending_participant(): void
    {
        $response = $this->post(route('archery.competition.store'), [
            'name' => 'Rizky Pratama',
            'whatsapp' => '628122222222',
            'rt' => '03',
            'competition_category' => 'remaja',
            'suggestion' => 'Datang bersama orang tua.',
        ]);

        $response->assertRedirect(route('archery.competition.create'));

        $this->assertDatabaseHas('archery_participants', [
            'parent_name' => 'Rizky Pratama',
            'parent_whatsapp' => '628122222222',
            'rt' => '03',
            'child_name' => 'Rizky Pratama',
            'child_school_class' => 'Remaja',
            'competition_category' => 'remaja',
            'event_name' => 'Lomba Panahan 17 Agustus 2026',
            'weekly_donation_amount' => 0,
            'status' => ArcheryParticipant::STATUS_PENDING,
        ]);
    }
}
