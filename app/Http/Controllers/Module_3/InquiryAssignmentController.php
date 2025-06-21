<?php

namespace App\Http\Controllers\Module_3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Agency;
use App\Models\Assignment;
use App\Models\JurisdictionReview;
use App\Models\Rejection;
use App\Models\Inquiry;

class InquiryAssignmentController extends Controller
{
    // ✅ Show assignment form to MCMC
    public function showAssignForm($inquiry_id)
    {
        $agencies = Agency::all();
        $inquiry = Inquiry::findOrFail($inquiry_id); // 🔧 Add this line to get the full inquiry
        return view('mcmc.assign', compact('inquiry', 'agencies')); // ✅ Pass $inquiry
    }


    // ✅ Handle assignment submission
    public function assignToAgency(Request $request)
    {
        $validated = $request->validate([
            'Inquiry_ID' => 'required|exists:inquiry,Inquiry_ID',
            'Agency_ID' => 'required|exists:agency,Agency_ID',
            'MCMC_ID' => 'required|exists:mcmc,MCMC_ID',
            'Assigned_Date' => 'required|date',
            'Reassigned' => 'required|boolean',
        ]);

        Assignment::create($validated);

        return redirect()->route('agency.assigned.list', ['agency_id' => $request->Agency_ID])
                         ->with('success', 'Inquiry assigned and visible to agency!');
    }

    // ✅ View assigned inquiries for an agency
    public function viewAssignedInquiries(Request $request)
    {
        $agencyId = $request->query('agency_id');

        $assignments = Assignment::with('inquiry')
            ->where('Agency_ID', $agencyId)
            ->get();

        return view('agency.assigned-inquiries', compact('assignments'));
    }

    // ✅ Show jurisdiction review form to agency
    public function showJurisdictionForm($assignment_id)
    {
        $assignment = Assignment::with('inquiry')->findOrFail($assignment_id);
        return view('agency.review-jurisdiction', compact('assignment'));
    }

    // ✅ Handle jurisdiction review submission
    public function submitJurisdiction(Request $request)
    {
        $request->validate([
            'Assignment_ID' => 'required|exists:assignment,Assignment_ID',
            'Inquiry_ID' => 'required|exists:inquiry,Inquiry_ID',
            'Jurisdiction_Status' => 'required|in:Within,Out of Jurisdiction',
            'Response_Date' => 'required|date',
            'Rejection_Reason' => 'nullable|string',
            'Agency_Comments' => 'nullable|string',
        ]);

        JurisdictionReview::create([
            'Assignment_ID' => $request->Assignment_ID,
            'Inquiry_ID' => $request->Inquiry_ID,
            'Jurisdiction_Status' => $request->Jurisdiction_Status,
            'Response_Date' => $request->Response_Date,
            'Agency_Comments' => $request->Agency_Comments,
        ]);

        if ($request->Jurisdiction_Status === 'Out of Jurisdiction') {
            Rejection::create([
                'Assignment_ID' => $request->Assignment_ID,
                'Inquiry_ID' => $request->Inquiry_ID,
                'Rejection_Reason' => $request->Rejection_Reason,
                'Agency_Comments' => $request->Agency_Comments,
            ]);
        }

        return redirect()->route('agency.assigned.list', ['agency_id' => auth()->user()->User_ID])
                         ->with('success', 'Jurisdiction review submitted successfully.');
    }

    // ✅ Show inquiry details for MCMC
    public function reviewInquiry($inquiry_id)
    {
        $inquiry = DB::table('inquiry')
            ->where('Inquiry_ID', $inquiry_id)
            ->select('Inquiry_ID', 'Inquiry_Title', 'Inquiry_Desc', 'Inquiry_SubDate')
            ->first();

        if (!$inquiry) {
            return view('mcmc.review-inquiry')->with('error', 'Inquiry not found.');
        }

        return view('mcmc.review-inquiry', ['inquiry' => $inquiry]);
    }


    // ✅ Show assigned agency to public user
    public function viewAssignment($inquiry_id)
    {
        $assignment = Assignment::with(['agency', 'inquiry'])
            ->where('Inquiry_ID', $inquiry_id)
            ->first();

        if (!$assignment) {
            return view('publicuser.assigned-agency')->with('error', 'No assignment found for this inquiry.');
        }

        return view('publicuser.assigned-agency', compact('assignment'));
    }
    
    // ✅ Display all inquiries for MCMC
    public function listAllInquiries()
    {
        $inquiries = Inquiry::all(); // You can use ->paginate(10) if needed
        return view('mcmc.review-inquiry', compact('inquiries')); // ← Use the correct Blade name
    }
    
}
