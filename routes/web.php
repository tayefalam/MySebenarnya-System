<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Module_2\InquiryFormController;
use App\Http\Controllers\Module_2\ReviewReportController;
use App\Http\Controllers\Module_3\InquiryAssignmentController;
use App\Http\Controllers\Module_3\AssignmentReportController;
use App\Http\Controllers\Module_3\InquiryTrackingController;
use App\Http\Controllers\InquiryProgressController;
use App\Http\Controllers\ProgressReportController;


//module 1
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ForgotPasswordController;
use Illuminate\Support\Facades\Auth;


//module 1 

Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        return match ($user->User_Type) {
            'Public User' => redirect()->route('user.dashboard'),
            'Agency' => redirect()->route('agency.dashboard'),
            'MCMC' => redirect()->route('mcmc.dashboard'),
            default => redirect()->route('login'),
        };
    }
    return redirect()->route('login');
})->name('home');

// Registration Routes
Route::get('/register-view', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

// Login Routes
Route::get('/login-view', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

// Forgot Password Routes
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Public User Routes - Only accessible by Public Users
    Route::middleware(['check.user.type:Public User'])->group(function () {
        Route::get('/user-dashboard', [ProfileController::class, 'userDashboard'])->name('user.dashboard');
        Route::get('/view-user-profile', [ProfileController::class, 'view'])->name('user.profile.view');
        Route::get('/update-user-profile', [ProfileController::class, 'editUserProfile'])->name('user.profile.edit');
        Route::post('/update-user-profile', [ProfileController::class, 'update'])->name('user.profile.update');
    });

    // Agency Password Change Routes (for temporary passwords) - Only accessible by Agency users
    Route::middleware(['check.user.type:Agency'])->group(function () {
        Route::get('/agency/change-password', [ProfileController::class, 'showChangePasswordForm'])->name('agency.change.password');
        Route::post('/agency/change-password', [ProfileController::class, 'changePassword'])->name('agency.change.password.submit');
    });
    
    // Agency Routes - Protected by user type and temp password check
    Route::middleware(['check.user.type:Agency', 'check.temp.password'])->group(function () {
        Route::get('/agency-dashboard', [ProfileController::class, 'agencyDashboard'])->name('agency.dashboard');
        Route::get('/view-agency-profile', [ProfileController::class, 'viewAgency'])->name('view.agency.profile');
        Route::get('/update-agency-profile', [ProfileController::class, 'editAgencyProfile'])->name('agency.profile.edit');
        Route::post('/update-agency-profile', [ProfileController::class, 'updateAgency'])->name('update.agency.profile');
        Route::post('/update-agency-password', [ProfileController::class, 'updatePassword'])->name('agency.updatePassword');
    });

    // MCMC Routes - Only accessible by MCMC users
    Route::middleware(['check.user.type:MCMC'])->group(function () {
        Route::get('/mcmc-dashboard', [RegisterController::class, 'mcmcDashboard'])->name('mcmc.dashboard');
        Route::get('/mcmc/register-agency', [RegisterController::class, 'showAgencyRegistrationForm'])->name('mcmc.register.agency');
        Route::post('/mcmc/register-agency', [RegisterController::class, 'registerAgency'])->name('mcmc.register.agency.submit');
        Route::get('/mcmc/view-registered-users', [RegisterController::class, 'viewRegisteredUsers'])->name('mcmc.view.registered.users');
        Route::post('/mcmc/resend-credentials/{agencyId}', [RegisterController::class, 'resendCredentials'])->name('mcmc.resend.credentials');
        Route::delete('/mcmc/user/{user}', [ProfileController::class, 'destroy'])->name('mcmc.users.destroy');

        // Schema management routes (MCMC Admin only)
        Route::post('/mcmc/update-agency-schema', [RegisterController::class, 'updateAgencySchema'])->name('mcmc.update.schema');
        Route::post('/mcmc/rollback-agency-schema', [RegisterController::class, 'rollbackAgencySchema'])->name('mcmc.rollback.schema');
        
        // MCMC Profile route (view only)
        Route::get('/mcmc/profile', [RegisterController::class, 'mcmcProfile'])->name('mcmc.profile');
        
        // MCMC Reports routes
        Route::get('/mcmc/reports', [ReportController::class, 'index'])->name('mcmc.reports');
        Route::get('/mcmc/reports/users', [ReportController::class, 'generateUsersReport'])->name('mcmc.reports.users');
        Route::get('/mcmc/reports/agencies', [ReportController::class, 'generateAgenciesReport'])->name('mcmc.reports.agencies');
        Route::get('/mcmc/reports/system', [ReportController::class, 'generateSystemReport'])->name('mcmc.reports.system');
        Route::get('/mcmc/reports/users/csv', [ReportController::class, 'exportUsersCSV'])->name('mcmc.reports.users.csv');
        Route::get('/mcmc/reports/custom', [ReportController::class, 'generateCustomReport'])->name('mcmc.reports.custom');
    });
    
    // Debug route for testing image display (accessible to all authenticated users)
    Route::get('/debug/profile-image', function() {
        $user = Auth::user();
        if (!$user) {
            return 'Not logged in';
        }
        
        $user = \App\Models\User::with('publicProfile')->find($user->User_ID);
        
        $debug = [
            'user_id' => $user->User_ID,
            'has_public_profile' => $user->publicProfile ? 'Yes' : 'No',
            'profile_image_filename' => $user->publicProfile ? $user->publicProfile->profile_image_filename : 'None',
            'profile_picture_field' => $user->publicProfile ? $user->publicProfile->Profile_Picture : 'None',
            'asset_url' => $user->publicProfile && $user->publicProfile->Profile_Picture ? 
                asset('storage/profile_images/' . $user->publicProfile->Profile_Picture) : 'No image',
            'storage_path' => storage_path('app/public/profile_images/'),
            'public_path' => public_path('storage/profile_images/'),
            'files_in_storage' => \Illuminate\Support\Facades\Storage::disk('public')->files('profile_images'),
            'app_url' => config('app.url'),
            'file_exists_check' => $user->publicProfile && $user->publicProfile->Profile_Picture ? 
                file_exists(public_path('storage/profile_images/' . $user->publicProfile->Profile_Picture)) : false,
        ];
        
        return response()->json($debug, 200, [], JSON_PRETTY_PRINT);
    })->name('debug.profile.image');
});

// Module 2, 3, 4 Routes
Route::middleware(['web'])->group(function () {

    /**
     * PUBLIC
     */
        Route::middleware(['check.user.type:Public User'])->group(function () {
        Route::get('/inquiries/create', [InquiryFormController::class, 'create'])->name('inquiries.create');// Add new inquiry form
        Route::post('/inquiries', [InquiryFormController::class, 'store'])->name('inquiries.store');// Store submitted inquiry
        Route::get('/inquiries/public', [InquiryFormController::class, 'viewPublic'])->name('inquiries.public');// View inquiries submitted by others
        Route::get('/inquiries/status', [InquiryFormController::class, 'status'])->name('inquiries.status');// Check status of own inquiries
    
        });

        Route::middleware(['auth'])->group(function () {
        Route::get('/inquiries/{id}/download', [InquiryFormController::class, 'downloadEvidence'])->name('inquiries.download'); 
        });

        Route::get('/my-inquiries', [InquiryTrackingController::class, 'listInquiries']);
        Route::get('/inquiry/assigned-agency/{inquiry_id}', [InquiryTrackingController::class, 'viewAssignment'])->name('assigned.agency');
    

    
    /**
     * MCMC 
     */
        Route::middleware(['check.user.type:MCMC'])->group(function () {
        Route::get('/review-inquiries', [ReviewReportController::class, 'index'])->name('inquiries.review');// View and review submitted inquiries
        Route::post('/inquiries/{id}/status', [ReviewReportController::class, 'updateStatus'])->name('inquiries.updateStatus');// Update inquiry status (accepted / Rejected)
        Route::get('/report-inquiries', [ReviewReportController::class, 'report'])->name('inquiries.report');// Generate report based on inquiries
        Route::get('/report/download', [ReviewReportController::class, 'downloadPDF'])->name('inquiries.report.download');//Download report as PDF
        });

        Route::get('/mcmc/review-inquiry/{inquiry_id}', [InquiryAssignmentController::class, 'reviewInquiry'])->name('mcmc.review-inquiry');
        Route::get('/assign-inquiry/{inquiry_id}', [InquiryAssignmentController::class, 'showAssignForm'])->name('assign.form');
        Route::post('/assign-inquiry', [InquiryAssignmentController::class, 'assignToAgency'])->name('assign.inquiry');
        Route::get('/mcmc/report', [AssignmentReportController::class, 'showReportForm'])->name('report.form');
        Route::get('/mcmc/dashboard', [AssignmentReportController::class, 'viewAnalytics'])->name('dashboard.analytics');
        Route::get('/mcmc/all-inquiries', [InquiryAssignmentController::class, 'listAllInquiries'])->name('mcmc.inquiries.list');
    


    /**
     * AGENCY 
     */
        Route::middleware(['check.user.type:Agency'])->group(function () {
        Route::get('/agency/inquiries', [InquiryFormController::class, 'agencyView'])->name('inquiries.agency');
        });
        Route::get('/agency/assigned-inquiries', [InquiryAssignmentController::class, 'viewAssignedInquiries'])->name('agency.assigned.list');
        Route::get('/agency/review-jurisdiction/{assignment_id}', [InquiryAssignmentController::class, 'showJurisdictionForm'])->name('agency.review.jurisdiction');
        Route::post('/agency/submit-jurisdiction', [InquiryAssignmentController::class, 'submitJurisdiction'])->name('jurisdiction.submit');

        Route::get('/progress', [InquiryProgressController::class, 'index']);
        Route::post('/progress', [InquiryProgressController::class, 'store']);
    
});



// ✅ Module 4 routes
Route::get('/progress', [InquiryProgressController::class, 'index']);
Route::post('/progress', [InquiryProgressController::class, 'store']);
Route::get('/progress/history/{inquiry_id}', [InquiryProgressController::class, 'history']);
Route::get('/progress/{progress_id}/edit', [InquiryProgressController::class, 'edit']);
Route::put('/progress/{progress_id}', [InquiryProgressController::class, 'update']); // ✅ this must match the form action

// ✅ Report route for MCMC summary view
Route::get('/report', [ProgressReportController::class, 'index']);

// ✅ Make /progress the homepage


