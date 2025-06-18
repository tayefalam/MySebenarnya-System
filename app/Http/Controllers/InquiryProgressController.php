<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InquiryProgress;

class InquiryProgressController extends Controller
{
    public function index()
    {
        $progress = InquiryProgress::all();
        return view('progress.index', compact('progress'));
    }

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
        ]);

        return redirect('/progress')->with('success', 'Inquiry progress added successfully.');
    }

    public function create() {}
    public function show(InquiryProgress $inquiryProgress) {}
    public function edit(InquiryProgress $inquiryProgress) {}
    public function update(Request $request, InquiryProgress $inquiryProgress) {}
    public function destroy(InquiryProgress $inquiryProgress) {}
}
