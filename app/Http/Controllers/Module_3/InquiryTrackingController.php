<?php

namespace App\Http\Controllers\Module_3;

use App\Http\Controllers\Controller; // ✅ Add this line
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ✅ This is the missing line!
use App\Models\Inquiry;
use App\Models\Assignment;

class InquiryTrackingController extends Controller
{
    // ✅ View all inquiries submitted by the public user

    public function listInquiries()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $user_id = Auth::user()->User_ID;

        $inquiries = Inquiry::where('User_ID', $user_id)->get();
        return view('publicuser.inquiry-list', compact('inquiries'));
    }


    public function viewAssignment($inquiry_id)
    {
        // Fetch latest assignment for this inquiry with agency info
        $assignment = Assignment::with('agency')
            ->where('Inquiry_ID', $inquiry_id)
            ->latest('Assigned_Date')
            ->first();

        return view('publicuser.assigned-agency', compact('assignment'));
    }
}
