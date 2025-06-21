<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InquiryProgressController;
use App\Http\Controllers\ProgressReportController;

// ✅ Module 4 routes
Route::get('/progress', [InquiryProgressController::class, 'index']);
Route::post('/progress', [InquiryProgressController::class, 'store']);
Route::get('/progress/history/{inquiry_id}', [InquiryProgressController::class, 'history']);
Route::get('/progress/{id}/edit', [InquiryProgressController::class, 'edit']);
Route::put('/progress/{id}', [InquiryProgressController::class, 'update']);


// ✅ Report route for MCMC summary view
Route::get('/report', [ProgressReportController::class, 'index']);

// ✅ Make /progress the homepage
Route::get('/', function () {
    return redirect('/progress');
});
