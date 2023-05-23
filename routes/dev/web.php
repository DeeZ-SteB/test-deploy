<?php

use App\Http\Controllers\Dev\Web\DevPageController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'dev',
    'as'     => 'dev.',
], function () {
    Route::get('test', DevPageController::class)->name('test');
});
