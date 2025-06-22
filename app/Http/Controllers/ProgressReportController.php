<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InquiryProgress;

class ProgressReportController extends Controller
{
    /**
     * Show a basic inquiry progress summary.
     */
    public function index()
    {
        $total = InquiryProgress::count();
        $pending = InquiryProgress::where('status', 'Pending')->count();
        $inProgress = InquiryProgress::where('status', 'In Progress')->count();
        $resolved = InquiryProgress::where('status', 'Resolved')->count();

        return view('report.index', compact('total', 'pending', 'inProgress', 'resolved'));
    }
}
