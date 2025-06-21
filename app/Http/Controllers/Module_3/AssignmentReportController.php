<?php

namespace App\Http\Controllers\Module_3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assignment;
use Illuminate\Support\Facades\DB;



class AssignmentReportController extends Controller
{
    public function showReportForm()
    {
        // Get all assignments with related data
        $assignments = Assignment::with(['inquiry', 'agency', 'mcmc'])->get();

        // Pass to view
        return view('mcmc.assignment-report', compact('assignments'));
    }
    // AssignmentReportController.php
    public function viewAnalytics()
    {
        // Total assignments count
        $totalAssignments = \App\Models\Assignment::count();

        // Assignments per agency (for bar chart)
        $assignmentsPerAgency = \App\Models\Assignment::selectRaw('Agency_ID, COUNT(*) as count')
            ->groupBy('Agency_ID')
            ->pluck('count', 'Agency_ID');

        // Assignments per month (for line chart or area chart)
        $assignmentsPerMonth = \App\Models\Assignment::selectRaw('MONTH(Assigned_Date) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');

        return view('mcmc.dashboard-analytics', compact('totalAssignments', 'assignmentsPerAgency', 'assignmentsPerMonth'));
    }

    public function reviewInquiry($inquiry_id)
{
    // Fetch inquiry data from the 'inquiry' table
    $inquiry = DB::table('inquiry')
        ->where('Inquiry_ID', $inquiry_id)
        ->select('Inquiry_ID', 'Inquiry_Title', 'Inquiry_Desc', 'Inquiry_SubDate')
        ->first();

    // Check if the inquiry exists
    if (!$inquiry) {
        return view('mcmc.review-inquiry')->with('error', 'Inquiry not found.');
    }

    // Pass the inquiry data to the view
    return view('mcmc.review-inquiry', ['inquiry' => $inquiry]);
}

}
