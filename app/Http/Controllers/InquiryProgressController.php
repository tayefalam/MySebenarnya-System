<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InquiryProgress;

class InquiryProgressController extends Controller
{
    /**
     * Display all inquiry progress records, with optional search.
     */
    public function index(Request $request)
    {
        $query = InquiryProgress::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('inquiry_id', 'like', "%$search%")
                  ->orWhere('status', 'like', "%$search%");
        }

        $progress = $query->orderBy('update_timestamp', 'desc')->get();

        return view('progress.index', compact('progress'));
    }

    /**
     * Store a new inquiry progress update.
     */
    public function store(Request $request)
    {
        $request->validate([
            'inquiry_id' => 'required|numeric',
            'status' => 'required|string',
        ]);

        InquiryProgress::create([
            'inquiry_id' => $request->inquiry_id,
            'agency_id' => $request->agency_id,
            'mcmc_id' => $request->mcmc_id,
            'status' => $request->status,
            'remarks' => $request->remarks,
            'update_timestamp' => now(), // Ensure timestamp is recorded
        ]);

        return redirect('/progress')->with('success', 'Inquiry progress added successfully.');
    }

    /**
     * Display full progress history for a specific inquiry ID.
     */
    public function history($inquiry_id)
    {
        $history = InquiryProgress::where('inquiry_id', $inquiry_id)
                    ->orderBy('update_timestamp', 'desc')
                    ->get();

        return view('progress.history', compact('history', 'inquiry_id'));
    }

    /**
     * Show the form for editing a specific progress entry.
     */
    public function edit($id)
    {
        $progress = InquiryProgress::findOrFail($id);
        return view('progress.edit', compact('progress'));
    }

    /**
     * Update the specified inquiry progress entry.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
            'remarks' => 'nullable|string',
        ]);

        $progress = InquiryProgress::findOrFail($id);
        $progress->update([
            'status' => $request->status,
            'remarks' => $request->remarks,
            'update_timestamp' => now(),
        ]);

        return redirect('/progress')->with('success', 'Progress updated successfully!');
    }

    /**
     * Delete the specified inquiry progress entry.
     */
    public function destroy($id)
    {
        $progress = InquiryProgress::findOrFail($id);
        $progress->delete();

        return redirect('/progress')->with('success', 'Progress entry deleted successfully!');
    }
}
