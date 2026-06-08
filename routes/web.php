<?php

use App\Http\Controllers\ArcheryRegistrationController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\PublicFinancialReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', LandingPageController::class)->name('home');
Route::get('/pendaftaran-panahan', [ArcheryRegistrationController::class, 'create'])->name('archery.registration.create');
Route::post('/pendaftaran-panahan', [ArcheryRegistrationController::class, 'store'])->name('archery.registration.store');
Route::get('/laporan-keuangan', PublicFinancialReportController::class)->name('financial-report.public');
