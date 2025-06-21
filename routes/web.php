<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Module_2\InquiryFormController;
use App\Http\Controllers\Module_2\ReviewReportController;
use App\Http\Controllers\Module_3\InquiryAssignmentController;
use App\Http\Controllers\Module_3\AssignmentReportController;
use App\Http\Controllers\Module_3\InquiryTrackingController;
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

    Route::get('/my-inquiries', [InquiryTrackingController::class, 'listInquiries']);
    Route::get('/inquiry/assigned-agency/{inquiry_id}', [InquiryTrackingController::class, 'viewAssignment'])->name('assigned.agency');


    
    /**
     * MCMC 
     */
   
    Route::get('/review-inquiries', [ReviewReportController::class, 'index'])->name('inquiries.review');// View and review submitted inquiries
    Route::post('/inquiries/{id}/status', [ReviewReportController::class, 'updateStatus'])->name('inquiries.updateStatus');// Update inquiry status (Approved / Rejected)
    Route::get('/report', [ReviewReportController::class, 'report'])->name('inquiries.report');// Generate report based on inquiries
    Route::get('/report/download', [ReviewReportController::class, 'downloadPDF'])->name('inquiries.report.download');//Download report as PDF

    Route::get('/mcmc/review-inquiry/{inquiry_id}', [InquiryAssignmentController::class, 'reviewInquiry'])->name('mcmc.review-inquiry');
    Route::get('/assign-inquiry/{inquiry_id}', [InquiryAssignmentController::class, 'showAssignForm'])->name('assign.form');
    Route::post('/assign-inquiry', [InquiryAssignmentController::class, 'assignToAgency'])->name('assign.inquiry');
    Route::get('/mcmc/report', [AssignmentReportController::class, 'showReportForm'])->name('report.form');
    Route::get('/mcmc/dashboard', [AssignmentReportController::class, 'viewAnalytics'])->name('dashboard.analytics');
    Route::get('/mcmc/all-inquiries', [InquiryAssignmentController::class, 'listAllInquiries'])->name('mcmc.inquiries.list');

    /**
     * AGENCY 
     */

    Route::get('/agency/inquiries', [InquiryFormController::class, 'agencyView'])->name('inquiries.agency');

    Route::get('/agency/assigned-inquiries', [InquiryAssignmentController::class, 'viewAssignedInquiries'])->name('agency.assigned.list');
    Route::get('/agency/review-jurisdiction/{assignment_id}', [InquiryAssignmentController::class, 'showJurisdictionForm'])
    ->name('agency.review.jurisdiction');
    Route::post('/agency/submit-jurisdiction', [InquiryAssignmentController::class, 'submitJurisdiction'])->name('jurisdiction.submit');

    Route::get('/progress', [InquiryProgressController::class, 'index']);
    Route::post('/progress', [InquiryProgressController::class, 'store']);

});


