<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\InquiryProgress;
use App\Models\Inquiry;
use App\Models\Notification; // ✅ Add this line

class InquiryProgressController extends Controller
{
    /**
     * Display all inquiry progress records, with optional search.
     */
    public function index(Request $request)
    {
        $query = InquiryProgress::query();

        // Only show records for the logged-in agency
        $query->where('agency_id', Auth::id());

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('status', 'like', "%$search%")
                  ->orWhereHas('inquiry', function ($sub) use ($search) {
                      $sub->where('title', 'like', "%$search%");
                  });
            });
        }

        $progress = $query->with('inquiry', 'agency')->orderBy('update_timestamp', 'desc')->get();
        $inquiries = Inquiry::all();

        return view('progress.index', compact('progress', 'inquiries'));
    }

    /**
     * Store a new inquiry progress update.
     */
    public function store(Request $request)
    {
        $request->validate([
            'inquiry_id' => 'required|numeric',
            'status' => 'required|string',
            'remarks' => 'nullable|string',
        ]);

        // Save progress
        $progress = InquiryProgress::create([
            'inquiry_id' => $request->inquiry_id,
            'agency_id' => Auth::id(),
            'status' => $request->status,
            'remarks' => $request->remarks,
            'update_timestamp' => now(),
        ]);

        // ✅ Create notification
        Notification::create([
            'inquiry_id' => $progress->inquiry_id,
            'agency_id' => $progress->agency_id,
            'mcmc_id' => null, // Update this if you have a value for MCMC
            'message' => 'Inquiry progress updated to: ' . $progress->status,
            'is_read' => false,
        ]);

        return redirect('/progress')->with('success', 'Inquiry progress added successfully.');
    }

    /**
     * Show full history for a specific inquiry ID.
     */
    public function history($inquiry_id)
    {
        $history = InquiryProgress::where('inquiry_id', $inquiry_id)
                                  ->where('agency_id', Auth::id())
                                  ->orderBy('update_timestamp', 'desc')
                                  ->get();

        return view('progress.history', compact('history', 'inquiry_id'));
    }

    /**
     * Show form to edit a specific progress record.
     */
    public function edit($id)
    {
        $progress = InquiryProgress::where('agency_id', Auth::id())->findOrFail($id);
        return view('progress.edit', compact('progress'));
    }

    /**
     * Update an existing inquiry progress record.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
            'remarks' => 'nullable|string',
        ]);

        $progress = InquiryProgress::where('agency_id', Auth::id())->findOrFail($id);
        $progress->update([
            'status' => $request->status,
            'remarks' => $request->remarks,
            'update_timestamp' => now(),
        ]);

        return redirect('/progress')->with('success', 'Progress updated successfully!');
    }
}
