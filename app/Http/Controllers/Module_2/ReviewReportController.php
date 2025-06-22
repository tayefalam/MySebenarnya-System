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
        $query = Inquiry::with(['user' => function ($query) {
        $query->select('User_ID', 'Name', 'Email');
        }])->whereNotNull('User_ID');


        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'accepted') {
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
        'status' => 'required|in:accepted,rejected,pending',
    ]);

    $statusMap = [
        'accepted' => true,
        'rejected' => false,
        'pending' => null,
    ];

    $inquiry = Inquiry::findOrFail($id);
    $inquiry->status = $statusMap[$request->status];
    $inquiry->save();

    //$reviewCountForThisInquiry = Review::where('inquiries_id', $inquiry->id)->count();

    Review::create([
        
      
    'status' => $statusMap[$request->status],
    'inquiries_id' => $inquiry->id,
    'user_id' => Auth::id(), // ✅ Add this line
]);


    return redirect()->back()->with('success', 'Inquiry status updated.');
}




    // MCMC: Generate report (number of inquiries)
    public function report()
    {
        $totalInquiries = Inquiry::count();
        $accepted = Inquiry::where('status', true)->count();
        $rejected = Inquiry::where('status', false)->count();

        return view('Module_2.inquiryReport', compact('totalInquiries', 'accepted', 'rejected'));
    }

    public function downloadPDF()
{
    $totalInquiries = Inquiry::count();
    $accepted = Inquiry::where('status', true)->count();
    $rejected = Inquiry::where('status', false)->count();

    $pdf = Pdf::loadView('Module_2.reportPDF', compact('totalInquiries', 'accepted', 'rejected'));
    return $pdf->download('inquiry_report.pdf');
}
}
