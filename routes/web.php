<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Module_2\InquiryFormController;
use App\Http\Controllers\Module_2\ReviewReportController;
use App\Http\Controllers\InquiryProgressController;

Route::get('/', function () {
    return redirect()->route('inquiries.create');
});
    Route::middleware(['web'])->group(function () {

    /**
     * PUBLIC
     */
    
    Route::get('/inquiries/create', [InquiryFormController::class, 'create'])->name('inquiries.create');// Add new inquiry form
    Route::post('/inquiries', [InquiryFormController::class, 'store'])->name('inquiries.store');// Store submitted inquiry
    Route::get('/inquiries/public', [InquiryFormController::class, 'viewPublic'])->name('inquiries.public');// View inquiries submitted by others
    Route::get('/inquiries/status', [InquiryFormController::class, 'status'])->name('inquiries.status');// Check status of own inquiries
    Route::get('/inquiries/{id}/download', [InquiryFormController::class, 'downloadEvidence'])->name('inquiries.download');// Download evidence file

    
    /**
     * MCMC 
     */
   
    Route::get('/review-inquiries', [ReviewReportController::class, 'index'])->name('inquiries.review');// View and review submitted inquiries
    Route::post('/inquiries/{id}/status', [ReviewReportController::class, 'updateStatus'])->name('inquiries.updateStatus');// Update inquiry status (Approved / Rejected)
    Route::get('/report', [ReviewReportController::class, 'report'])->name('inquiries.report');// Generate report based on inquiries
    Route::get('/report/download', [ReviewReportController::class, 'downloadPDF'])->name('inquiries.report.download');//Download report as PDF

    /**
     * AGENCY 
     */

    Route::get('/agency/inquiries', [InquiryFormController::class, 'agencyView'])->name('inquiries.agency');

    Route::get('/progress', [InquiryProgressController::class, 'index']);
    Route::post('/progress', [InquiryProgressController::class, 'store']);

});


