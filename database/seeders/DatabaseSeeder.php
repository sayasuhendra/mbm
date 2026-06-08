<?php

namespace Database\Seeders;

use App\Models\ArcheryParticipant;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Income;
use App\Models\IncomeCategory;
use App\Models\Setting;
use App\Models\TrainingSchedule;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['Super Admin', 'Ketua Klub', 'Bendahara', 'Admin'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }

        $permissions = [
            'view participants',
            'manage participants',
            'view finances',
            'manage finances',
            'print reports',
            'view broadcasts',
            'manage broadcasts',
            'manage settings',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        Role::findByName('Super Admin')->syncPermissions($permissions);
        Role::findByName('Ketua Klub')->syncPermissions(['view participants', 'view finances', 'view broadcasts']);
        Role::findByName('Bendahara')->syncPermissions(['view finances', 'manage finances', 'print reports']);
        Role::findByName('Admin')->syncPermissions(['view participants', 'manage participants', 'manage broadcasts', 'view broadcasts']);

        $admin = User::firstOrCreate(
            ['email' => 'admin@mbmyouth.test'],
            ['name' => 'Super Admin', 'password' => Hash::make('password')]
        );
        $admin->assignRole('Super Admin');

        foreach (['Infak Panahan', 'Donasi', 'Sponsor', 'Lainnya'] as $name) {
            IncomeCategory::firstOrCreate(['name' => $name], ['is_active' => true]);
        }

        foreach (['Peralatan', 'Konsumsi', 'Transportasi', 'Operasional', 'Lainnya'] as $name) {
            ExpenseCategory::firstOrCreate(['name' => $name], ['is_active' => true]);
        }

        $settings = [
            ['mosque_name', 'Masjid Baitul Muttaqin', 'string', 'identity'],
            ['logo', '', 'string', 'identity'],
            ['address', 'Komplek Masjid Baitul Muttaqin', 'string', 'contact'],
            ['whatsapp', '6281234567890', 'string', 'contact'],
            ['instagram', '@baitulmuttaqin.youth', 'string', 'contact'],
            ['google_maps', 'https://maps.google.com', 'url', 'contact'],
            ['default_weekly_donation', '5000', 'integer', 'finance'],
            ['whatsapp_gateway', 'mock', 'string', 'integration'],
        ];

        foreach ($settings as [$key, $value, $type, $group]) {
            Setting::updateOrCreate(['key' => $key], compact('value', 'type', 'group'));
        }

        TrainingSchedule::firstOrCreate([
            'title' => 'Latihan Rutin Sabtu Pagi',
            'day_of_week' => 6,
        ], [
            'starts_at' => '07:00',
            'ends_at' => '09:00',
            'location' => 'Halaman Masjid Baitul Muttaqin',
            'description' => 'Latihan teknik dasar, adab, dan evaluasi singkat.',
            'is_active' => true,
        ]);

        $participants = [
            ['parent_name' => 'Ahmad Fauzi', 'parent_whatsapp' => '628111111111', 'child_name' => 'Ibrahim Fauzi', 'child_age' => 12, 'child_school_class' => 'Kelas 6 SDIT Al Ikhlas'],
            ['parent_name' => 'Siti Aminah', 'parent_whatsapp' => '628222222222', 'child_name' => 'Maryam Zahra', 'child_age' => 13, 'child_school_class' => 'Kelas 7 SMP'],
            ['parent_name' => 'Budi Santoso', 'parent_whatsapp' => '628333333333', 'child_name' => 'Yusuf Santoso', 'child_age' => 14, 'child_school_class' => 'Kelas 8 MTs'],
        ];

        foreach ($participants as $index => $participant) {
            ArcheryParticipant::firstOrCreate([
                'member_number' => 'KPRMBM-'.now()->format('Ym').'-'.str_pad((string) ($index + 1), 4, '0', STR_PAD_LEFT),
            ], [
                ...$participant,
                'parent_address' => 'Sekitar Masjid Baitul Muttaqin',
                'training_permission' => true,
                'weekly_donation_amount' => [5000, 10000, 15000][$index],
                'equipment_option' => 'shared_contribution',
                'suggestion' => null,
                'status' => ArcheryParticipant::STATUS_ACTIVE,
                'registered_at' => now()->subDays(20 - $index),
            ]);
        }

        $infakCategory = IncomeCategory::where('name', 'Infak Panahan')->first();
        $donationCategory = IncomeCategory::where('name', 'Donasi')->first();
        $equipmentCategory = ExpenseCategory::where('name', 'Peralatan')->first();

        Income::firstOrCreate(['date' => now()->startOfMonth(), 'source' => 'Infak latihan pekan pertama'], [
            'income_category_id' => $infakCategory->id,
            'amount' => 150000,
            'description' => 'Infak peserta panahan',
            'created_by' => $admin->id,
        ]);

        Income::firstOrCreate(['date' => now()->startOfMonth()->addDays(2), 'source' => 'Donatur jamaah'], [
            'income_category_id' => $donationCategory->id,
            'amount' => 500000,
            'description' => 'Dukungan kegiatan remaja',
            'created_by' => $admin->id,
        ]);

        Expense::firstOrCreate(['date' => now()->startOfMonth()->addDays(3), 'description' => 'Target face dan anak panah latihan'], [
            'expense_category_id' => $equipmentCategory->id,
            'amount' => 275000,
            'created_by' => $admin->id,
        ]);
    }
}
