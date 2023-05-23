<?php

use App\Http\Controllers\Analytics\Api\V1\AnalyticsApiController;
use App\Http\Controllers\Widgets\Charts\Api\V1\CandidatesPerJobsApiController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'analytics',
    'as'     => 'analytics.',
], function () {

    Route::group([
        'prefix' => 'charts',
        'as'     => 'charts.',
    ], function () {
        Route::post('all', [AnalyticsApiController::class, 'allChartsData'])->name('all');
    });

    // TODO DEl this route group. It's only demo
    Route::group([
        'prefix' => 'chart',
        'as'     => 'chart.',
    ], function () {
        Route::get('candidates-per-jobs', [CandidatesPerJobsApiController::class, 'demo'])
            ->name('candidates-per-jobs');
    });
});
