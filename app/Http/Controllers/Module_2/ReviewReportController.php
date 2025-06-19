<?php

namespace App\Http\Controllers\Module_2;

use App\Models\Review;
use App\Models\Inquiry;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ReviewReportController extends Controller
{
    // MCMC: View all inquiries
    public function index(Request $request)
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

        return view('Module_2.reviewInquiry', compact('inquiries'));
    }



  public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:approved,rejected,pending',
    ]);

    $statusMap = [
        'approved' => true,
        'rejected' => false,
        'pending' => null,
    ];

    $inquiry = Inquiry::findOrFail($id);
    $inquiry->status = $statusMap[$request->status];
    $inquiry->save();

    //$reviewCountForThisInquiry = Review::where('inquiries_id', $inquiry->id)->count();

    Review::create([
        'status' => $statusMap[$request->status],
        //'total_received' => $reviewCountForThisInquiry + 1,
        // 'user_id' => Auth::id(),
        'inquiries_id' => $inquiry->id,
    ]);

    return redirect()->back()->with('success', 'Inquiry status updated.');
}




    // MCMC: Generate report (number of inquiries)
    public function report()
    {
        $totalInquiries = Inquiry::count();
        $approved = Inquiry::where('status', true)->count();
        $rejected = Inquiry::where('status', false)->count();

        return view('Module_2.inquiryReport', compact('totalInquiries', 'approved', 'rejected'));
    }

    public function downloadPDF()
{
    $totalInquiries = Inquiry::count();
    $approved = Inquiry::where('status', true)->count();
    $rejected = Inquiry::where('status', false)->count();

    $pdf = Pdf::loadView('Module_2.reportPDF', compact('totalInquiries', 'approved', 'rejected'));
    return $pdf->download('inquiry_report.pdf');
}
}
