<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InquiryProgressController;

Route::get('/progress', [InquiryProgressController::class, 'index']);
Route::post('/progress', [InquiryProgressController::class, 'store']);
