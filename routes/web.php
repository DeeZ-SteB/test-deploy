<?php

use App\Http\Controllers\Pages\Analytics\AnalyticsPageController;
use App\Http\Controllers\Pages\PeoplePartner\PeoplePartnerPageController;
use App\Http\Controllers\Pages\Recruiting\RecruitingPageController;
use App\Http\Controllers\ResumesParserController;
use App\Http\Controllers\Pages\Main\MainPageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatsParserController;
use Illuminate\Support\Facades\Route;

Route::group([
    'as' => 'page.',
], function () {
    Route::get('/', MainPageController::class)->name('main');
    Route::get('/analytics', AnalyticsPageController::class)->name('analytics');
    Route::get('/recruiting', RecruitingPageController::class)->name('recruiting');
    Route::get('/people-partner', PeoplePartnerPageController::class)->name('people-partner');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/resumes-parser', [ResumesParserController::class, 'get'])->name('ajax-resumes-parser');
Route::post('/stats-parser', [StatsParserController::class, 'get'])->name('ajax-stats-parser');

require __DIR__.'/auth.php';
