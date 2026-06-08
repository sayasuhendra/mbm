<?php

namespace App\Http\Controllers;

use App\Models\ArcheryParticipant;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Setting;
use App\Models\TrainingSchedule;
use App\Services\Finance\FinancialReportService;
use Illuminate\View\View;

class LandingPageController extends Controller
{
    public function __invoke(FinancialReportService $reports): View
    {
        $start = now()->startOfMonth();
        $end = now()->endOfMonth();

        return view('public.home', [
            'participantCount' => ArcheryParticipant::query()->count(),
            'activeParticipantCount' => ArcheryParticipant::query()->active()->count(),
            'monthlyIncome' => (int) Income::query()->whereBetween('date', [$start, $end])->sum('amount'),
            'monthlyExpense' => (int) Expense::query()->whereBetween('date', [$start, $end])->sum('amount'),
            'financialSummary' => $reports->summary(),
            'schedules' => TrainingSchedule::query()->where('is_active', true)->orderBy('day_of_week')->orderBy('starts_at')->get(),
            'galleries' => \App\Models\Gallery::query()->where('is_active', true)->with('media')->latest()->get(),
            'settings' => [
                'mosque_name' => Setting::value('mosque_name', 'Masjid Baitul Muttaqin'),
                'address' => Setting::value('address', 'Alamat Masjid Baitul Muttaqin'),
                'whatsapp' => Setting::value('whatsapp', '6280000000000'),
                'instagram' => Setting::value('instagram', '@baitulmuttaqin'),
                'google_maps' => Setting::value('google_maps', '#'),
            ],
        ]);
    }
}
