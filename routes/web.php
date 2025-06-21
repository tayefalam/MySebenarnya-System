<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InquiryProgressController;
use App\Http\Controllers\ProgressReportController;

Route::get('/progress', [InquiryProgressController::class, 'index']);
Route::post('/progress', [InquiryProgressController::class, 'store']);
Route::get('/progress/history/{inquiry_id}', [InquiryProgressController::class, 'history']);
Route::get('/progress/{id}/edit', [InquiryProgressController::class, 'edit']);
Route::put('/progress/{id}', [InquiryProgressController::class, 'update']);
Route::delete('/progress/{id}', [InquiryProgressController::class, 'destroy']);

// ✅ New: Report route for MCMC summary view
Route::get('/report', [ProgressReportController::class, 'index']);
