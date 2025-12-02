<?php

require __DIR__ . '/auth.php';
require __DIR__ . '/common.php';
require __DIR__ . '/superadmin.php';
require __DIR__ . '/admin.php';
use App\Http\Controllers\OrganizationSelectionController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/select-organization', [OrganizationSelectionController::class, 'showSelectionForm'])->name('organization.select');
    Route::post('/select-organization', [OrganizationSelectionController::class, 'processSelection'])->name('organization.select.post');
    Route::post('/change-organization', [OrganizationSelectionController::class, 'changeOrganization'])->name('organization.change');
});
require __DIR__ . '/customer.php';
