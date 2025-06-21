<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InquiryProgressController;
use App\Http\Controllers\ProgressReportController;

// ✅ Module 4 routes
Route::get('/progress', [InquiryProgressController::class, 'index']);
Route::post('/progress', [InquiryProgressController::class, 'store']);
Route::get('/progress/history/{inquiry_id}', [InquiryProgressController::class, 'history']);
Route::get('/progress/{progress_id}/edit', [InquiryProgressController::class, 'edit']);
Route::put('/progress/{progress_id}', [InquiryProgressController::class, 'update']); // ✅ this must match the form action

// ✅ Report route for MCMC summary view
Route::get('/report', [ProgressReportController::class, 'index']);

// ✅ Make /progress the homepage
Route::get('/', function () {
    return redirect('/progress');
});
