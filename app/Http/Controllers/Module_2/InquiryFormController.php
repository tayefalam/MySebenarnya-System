<?php

namespace App\Http\Controllers\Module_2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Storage;



class InquiryFormController extends Controller
{
    // Show form to add inquiry
    public function create()
    {
        return view('Module_2.addInquiry');
    }

    // Store inquiry submission
    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'date' => 'required|date',
        'evidence' => 'nullable|file|mimes:pdf,jpg,jpeg,png,docx|max:51200'
    ]);

    $evidencePath = null;
    if ($request->hasFile('evidence')) {
        $evidencePath = $request->file('evidence')->store('evidence', 'public');
    }

    Inquiry::create([
        'title' => $request->title,
        'description' => $request->description,
        'date' => $request->date,
        'status' => null,
        'evidence' => $evidencePath,
        //'user_id' => auth()->id()
    ]);

    return redirect()->route('inquiries.create')->with('success', 'The inquiry has been sent. Please wait for the status of the responses.');
}



    // Show submitted status
    public function status(Request $request)
{
    $query = Inquiry::query();

    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('title', 'like', '%' . $request->search . '%')
              ->orWhere('description', 'like', '%' . $request->search . '%');
        });
    }

    if ($request->filled('status')) {
        if ($request->status === 'approved') {
            $query->where('status', true);
        } elseif ($request->status === 'rejected') {
            $query->where('status', false);
        } elseif ($request->status === 'pending') {
            $query->whereNull('status');
        }
    }

    $inquiries = $query->orderBy('created_at', 'desc')->paginate(10);

    return view('Module_2.statusUpdate', compact('inquiries'));
    
}

        //$inquiries = Inquiry::where('user_id', auth()->id())->get();
        
    
    


    // Public can view all inquiries
    public function viewPublic(Request $request)
{
    $query = Inquiry::query();

    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('title', 'like', '%' . $request->search . '%')
              ->orWhere('description', 'like', '%' . $request->search . '%');
        });
    }

    if ($request->filled('status')) {
        if ($request->status === 'approved') {
            $query->where('status', true);
        } elseif ($request->status === 'rejected') {
            $query->where('status', false);
        } elseif ($request->status === 'pending') {
            $query->whereNull('status');
        }
    }

    $inquiries = $query->orderBy('created_at', 'desc')->paginate(10);

    return view('Module_2.viewPublicInquiry', compact('inquiries'));
}



    // Download evidence
    public function downloadEvidence($id)
{
    $inquiry = Inquiry::findOrFail($id);

    if (!$inquiry->evidence || !Storage::disk('public')->exists($inquiry->evidence)) {
        abort(404, 'Evidence file not found.');
    }

    $filePath = storage_path('app/public/' . $inquiry->evidence);
    return response()->download($filePath);
}

public function agencyView(Request $request)
{
    $query = Inquiry::query();

    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('title', 'like', '%' . $request->search . '%')
              ->orWhere('description', 'like', '%' . $request->search . '%');
        });
    }

    if ($request->filled('status')) {
        if ($request->status === 'approved') {
            $query->where('status', true);
        } elseif ($request->status === 'rejected') {
            $query->where('status', false);
        } elseif ($request->status === 'pending') {
            $query->whereNull('status');
        }
    }

    $inquiries = $query->orderBy('created_at', 'desc')->paginate(10);

    return view('Module_2.agencyReview', compact('inquiries'));
}
}
