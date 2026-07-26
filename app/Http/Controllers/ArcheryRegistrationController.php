<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArcheryRegistrationRequest;
use App\Services\Participants\ArcheryRegistrationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ArcheryRegistrationController extends Controller
{
    public function create(): View
    {
        return view('public.archery-registration');
    }

    public function store(StoreArcheryRegistrationRequest $request, ArcheryRegistrationService $registrations): RedirectResponse
    {
        $registrations->register($request->registrationData());

        return redirect()
            ->route($request->routeIs('archery.competition.*') ? 'archery.competition.create' : 'archery.registration.create')
            ->with('success', 'Pendaftaran berhasil dikirim. Data akan segera diverifikasi oleh panitia.');
    }
}
