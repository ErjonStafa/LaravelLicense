<?php


Route::middleware('package-web')->group(function () {
    Route::get('license/activate', [\Erjon\LaravelLicense\Http\Controllers\LicenseController::class, 'showActivateForm'])->name('license.activate');
    Route::post('license/activate', [\Erjon\LaravelLicense\Http\Controllers\LicenseController::class, 'activateLicense'])->middleware('throttle:6');
});
