<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Agency;
use App\Models\PublicUser;
use App\Models\Mcmc;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Display the reports dashboard for MCMC
     */
    public function index()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors(['error' => 'Please login first']);
        }

        // Validate MCMC access
        if (!Mcmc::validateMcmcAccess(Auth::user())) {
            return redirect()->route('login')->withErrors(['error' => 'Unauthorized access']);
        }

        // Log activity
        Mcmc::logActivity('reports_dashboard_access');

        // Get summary statistics for the reports page
        $stats = $this->getReportStats();

        return view('manage_user.mcmc_view.generate_report', compact('stats'));
    }

    /**
     * Generate Users Profile Report
     */
    public function generateUsersReport(Request $request)
    {
        try {
            // Check authentication and authorization
            if (!Auth::check() || !Mcmc::validateMcmcAccess(Auth::user())) {
                return redirect()->route('login')->withErrors(['error' => 'Unauthorized access']);
            }

            $format = $request->input('format', 'pdf'); // pdf or html
            $userType = $request->input('user_type', 'all'); // all, public_user, agency
            $dateFrom = $request->input('date_from');
            $dateTo = $request->input('date_to');

            // Get users data based on filters
            $usersData = $this->getUsersData($userType, $dateFrom, $dateTo);
            $stats = $this->getDetailedStats($userType, $dateFrom, $dateTo);

            // Prepare report data
            $reportData = [
                'title' => 'Users Profile Report',
                'generated_at' => Carbon::now()->format('d M Y, H:i:s'),
                'generated_by' => Auth::user()->Name,
                'filters' => [
                    'user_type' => $userType,
                    'date_from' => $dateFrom ? Carbon::parse($dateFrom)->format('d M Y') : 'All time',
                    'date_to' => $dateTo ? Carbon::parse($dateTo)->format('d M Y') : 'Present',
                ],
                'stats' => $stats,
                'users' => $usersData,
            ];

            // Log report generation
            Mcmc::logActivity('users_report_generated', [
                'user_type' => $userType,
                'format' => $format,
                'total_records' => count($usersData),
            ]);

            if ($format === 'html') {
                return view('manage_user.mcmc_view.generate_report', $reportData);
            }

            // Generate PDF
            $reportData['is_pdf'] = true;
            $pdf = Pdf::loadView('manage_user.mcmc_view.generate_report', $reportData);
            $pdf->setPaper('A4', 'portrait');
            
            $filename = 'users_report_' . Carbon::now()->format('Y-m-d_H-i-s') . '.pdf';
            
            return $pdf->download($filename);

        } catch (\Exception $e) {
            Log::error('Report generation failed: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to generate report: ' . $e->getMessage()]);
        }
    }

    /**
     * Generate Agencies Report
     */
    public function generateAgenciesReport(Request $request)
    {
        try {
            // Check authentication and authorization
            if (!Auth::check() || !Mcmc::validateMcmcAccess(Auth::user())) {
                return redirect()->route('login')->withErrors(['error' => 'Unauthorized access']);
            }

            $format = $request->input('format', 'pdf');
            $section = $request->input('section', 'all');
            $dateFrom = $request->input('date_from');
            $dateTo = $request->input('date_to');

            // Get agencies data
            $agenciesData = $this->getAgenciesData($section, $dateFrom, $dateTo);
            $agencyStats = $this->getAgencyStats($section, $dateFrom, $dateTo);

            $reportData = [
                'title' => 'Agencies Report',
                'generated_at' => Carbon::now()->format('d M Y, H:i:s'),
                'generated_by' => Auth::user()->Name,
                'filters' => [
                    'section' => $section,
                    'date_from' => $dateFrom ? Carbon::parse($dateFrom)->format('d M Y') : 'All time',
                    'date_to' => $dateTo ? Carbon::parse($dateTo)->format('d M Y') : 'Present',
                ],
                'stats' => $agencyStats,
                'agencies' => $agenciesData,
            ];

            // Log report generation
            Mcmc::logActivity('agencies_report_generated', [
                'section' => $section,
                'format' => $format,
                'total_records' => count($agenciesData),
            ]);

            if ($format === 'html') {
                return view('manage_user.mcmc_view.generate_report', $reportData);
            }

            // Generate PDF
            $reportData['is_pdf'] = true;
            $pdf = Pdf::loadView('manage_user.mcmc_view.generate_report', $reportData);
            $pdf->setPaper('A4', 'portrait');
            
            $filename = 'agencies_report_' . Carbon::now()->format('Y-m-d_H-i-s') . '.pdf';
            
            return $pdf->download($filename);

        } catch (\Exception $e) {
            Log::error('Agency report generation failed: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to generate report: ' . $e->getMessage()]);
        }
    }

    /**
     * Generate Comprehensive System Report
     */
    public function generateSystemReport(Request $request)
    {
        try {
            // Check authentication and authorization
            if (!Auth::check() || !Mcmc::validateMcmcAccess(Auth::user())) {
                return redirect()->route('login')->withErrors(['error' => 'Unauthorized access']);
            }

            $format = $request->input('format', 'pdf');

            // Get comprehensive system data
            $systemData = $this->getSystemData();

            $reportData = [
                'title' => 'Comprehensive System Report',
                'generated_at' => Carbon::now()->format('d M Y, H:i:s'),
                'generated_by' => Auth::user()->Name,
                'system_data' => $systemData,
            ];

            // Log report generation
            Mcmc::logActivity('system_report_generated', [
                'format' => $format,
            ]);

            if ($format === 'html') {
                return view('manage_user.mcmc_view.generate_report', $reportData);
            }

            // Generate PDF
            $reportData['is_pdf'] = true;
            $pdf = Pdf::loadView('manage_user.mcmc_view.generate_report', $reportData);
            $pdf->setPaper('A4', 'portrait');
            
            $filename = 'system_report_' . Carbon::now()->format('Y-m-d_H-i-s') . '.pdf';
            
            return $pdf->download($filename);

        } catch (\Exception $e) {
            Log::error('System report generation failed: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to generate report: ' . $e->getMessage()]);
        }
    }

    /**
     * Export Users Data as CSV
     */
    public function exportUsersCSV(Request $request)
    {
        try {
            // Check authentication and authorization
            if (!Auth::check() || !Mcmc::validateMcmcAccess(Auth::user())) {
                return redirect()->route('login')->withErrors(['error' => 'Unauthorized access']);
            }

            $userType = $request->input('user_type', 'all');
            $dateFrom = $request->input('date_from');
            $dateTo = $request->input('date_to');

            $usersData = $this->getUsersData($userType, $dateFrom, $dateTo);

            $filename = 'users_export_' . Carbon::now()->format('Y-m-d_H-i-s') . '.csv';

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $callback = function () use ($usersData) {
                $file = fopen('php://output', 'w');
                
                // CSV Headers
                fputcsv($file, [
                    'User ID',
                    'Name',
                    'Email',
                    'Contact Number',
                    'User Type',
                    'Status',
                    'Registration Date',
                    'Agency Section',
                    'Agency Address',
                    'Website'
                ]);

                // CSV Data
                foreach ($usersData as $user) {
                    fputcsv($file, [
                        $user->User_ID,
                        $user->Name ?? '',
                        $user->Email ?? '',
                        $user->Contact_Number ?? '',
                        $user->User_Type ?? '',
                        $user->Status ?? '',
                        $user->created_at ? $user->created_at->format('Y-m-d H:i:s') : '',
                        $user->agency->Agency_Section ?? '',
                        $user->agency->Address ?? '',
                        $user->agency->Website ?? '',
                    ]);
                }

                fclose($file);
            };

            // Log CSV export
            Mcmc::logActivity('users_csv_exported', [
                'user_type' => $userType,
                'total_records' => count($usersData),
            ]);

            return response()->stream($callback, 200, $headers);

        } catch (\Exception $e) {
            Log::error('CSV export failed: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to export CSV: ' . $e->getMessage()]);
        }
    }

    /**
     * Get basic report statistics
     */
    private function getReportStats()
    {
        return [
            'total_users' => User::count(),
            'total_public_users' => User::where('User_Type', 'Public User')->count(),
            'total_agencies' => User::where('User_Type', 'Agency')->count(),
            'active_users' => User::where('Status', 'Active')->count(),
            'recent_registrations' => User::where('created_at', '>=', Carbon::now()->subDays(30))->count(),
        ];
    }

    /**
     * Get users data based on filters
     */
    private function getUsersData($userType, $dateFrom = null, $dateTo = null)
    {
        $query = User::with(['agency', 'publicUser']);

        // Filter by user type
        if ($userType !== 'all') {
            $expectedType = match ($userType) {
                'public' => 'Public User',
                'public_user' => 'Public User',
                'agency' => 'Agency',
                default => null,
            };
            if ($expectedType) {
                $query->where('User_Type', $expectedType);
            }
        }

        // Exclude MCMC users from reports
        $query->where('User_Type', '!=', 'MCMC');

        // Filter by date range
        if ($dateFrom) {
            $query->whereDate('created_at', '>=', Carbon::parse($dateFrom));
        }
        if ($dateTo) {
            $query->whereDate('created_at', '<=', Carbon::parse($dateTo));
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    /**
     * Get detailed statistics
     */
    private function getDetailedStats($userType, $dateFrom = null, $dateTo = null)
    {
        $query = User::where('User_Type', '!=', 'MCMC');

        if ($dateFrom) {
            $query->whereDate('created_at', '>=', Carbon::parse($dateFrom));
        }
        if ($dateTo) {
            $query->whereDate('created_at', '<=', Carbon::parse($dateTo));
        }

        $baseQuery = clone $query;

        return [
            'total' => $baseQuery->count(),
            'public_users' => (clone $baseQuery)->where('User_Type', 'Public User')->count(),
            'agencies' => (clone $baseQuery)->where('User_Type', 'Agency')->count(),
            'active' => (clone $baseQuery)->where('Status', 'Active')->count(),
            'inactive' => (clone $baseQuery)->where('Status', '!=', 'Active')->count(),
        ];
    }

    /**
     * Get agencies data based on filters
     */
    private function getAgenciesData($section, $dateFrom = null, $dateTo = null)
    {
        $query = Agency::with('user');

        if ($section !== 'all') {
            $query->where('Agency_Section', $section);
        }

        if ($dateFrom) {
            $query->whereDate('Register_Date', '>=', Carbon::parse($dateFrom));
        }
        if ($dateTo) {
            $query->whereDate('Register_Date', '<=', Carbon::parse($dateTo));
        }

        return $query->orderBy('Register_Date', 'desc')->get();
    }

    /**
     * Get agency statistics
     */
    private function getAgencyStats($section, $dateFrom = null, $dateTo = null)
    {
        $query = Agency::query();

        if ($dateFrom) {
            $query->whereDate('Register_Date', '>=', Carbon::parse($dateFrom));
        }
        if ($dateTo) {
            $query->whereDate('Register_Date', '<=', Carbon::parse($dateTo));
        }

        $baseQuery = clone $query;

        $sectionStats = Agency::select('Agency_Section', DB::raw('count(*) as count'))
            ->groupBy('Agency_Section')
            ->pluck('count', 'Agency_Section')
            ->toArray();

        return [
            'total' => $baseQuery->count(),
            'by_section' => $sectionStats,
            'with_website' => (clone $baseQuery)->whereNotNull('Website')->where('Website', '!=', '')->count(),
            'recent_30_days' => (clone $baseQuery)->where('Register_Date', '>=', Carbon::now()->subDays(30))->count(),
        ];
    }

    /**
     * Get comprehensive system data
     */
    private function getSystemData()
    {
        $totalUsers = User::count();
        $totalPublicUsers = User::where('User_Type', 'Public User')->count();
        $totalAgencies = User::where('User_Type', 'Agency')->count();
        $totalMcmc = User::where('User_Type', 'MCMC')->count();

        // Registration trends (last 12 months)
        $registrationTrends = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $count = User::whereYear('created_at', $date->year)
                        ->whereMonth('created_at', $date->month)
                        ->where('User_Type', '!=', 'MCMC')
                        ->count();
            $registrationTrends[] = [
                'month' => $date->format('M Y'),
                'count' => $count
            ];
        }

        // Agency sections breakdown
        $agencySections = Agency::select('Agency_Section', DB::raw('count(*) as count'))
            ->groupBy('Agency_Section')
            ->orderBy('count', 'desc')
            ->get();

        // Status breakdown
        $statusBreakdown = User::select('Status', DB::raw('count(*) as count'))
            ->where('User_Type', '!=', 'MCMC')
            ->groupBy('Status')
            ->get();

        return [
            'overview' => [
                'total_users' => $totalUsers,
                'total_public_users' => $totalPublicUsers,
                'total_agencies' => $totalAgencies,
                'total_mcmc' => $totalMcmc,
            ],
            'registration_trends' => $registrationTrends,
            'agency_sections' => $agencySections,
            'status_breakdown' => $statusBreakdown,
            'system_health' => [
                'database_status' => 'Operational',
                'last_backup' => 'N/A',
                'uptime' => '99.9%',
            ]
        ];
    }

    /**
     * Generate Custom Report
     */
    public function generateCustomReport(Request $request)
    {
        try {
            $reportType = $request->input('report_type', 'users');
            $format = $request->input('format', 'html');
            
            // Get selected fields
            $selectedFields = $request->input($reportType . '_fields', []);
            if (empty($selectedFields)) {
                return redirect()->back()->with('error', 'Please select at least one field to include in the report.');
            }
            
            // Build query based on report type and filters
            $data = [];
            $title = '';
            
            switch ($reportType) {
                case 'users':
                    $data = $this->buildCustomUsersQuery($request, $selectedFields);
                    $title = 'Custom Users Report';
                    break;
                    
                case 'agencies':
                    $data = $this->buildCustomAgenciesQuery($request, $selectedFields);
                    $title = 'Custom Agencies Report';
                    break;
                    
                case 'system':
                    $data = $this->buildCustomSystemQuery($request, $selectedFields);
                    $title = 'Custom System Report';
                    break;
            }
            
            $reportData = [
                'title' => $title,
                'report_type' => $reportType,
                'selected_fields' => $selectedFields,
                'format' => $format,
                $reportType => $data,
            ];
            
            // Log the custom report generation
            Mcmc::logActivity('custom_report_generated', [
                'report_type' => $reportType,
                'format' => $format,
                'fields_count' => count($selectedFields),
                'records_count' => is_array($data) ? count($data) : 1,
            ]);
            
            if ($format === 'html') {
                return view('manage_user.mcmc_view.generate_report', $reportData);
            }
            
            if ($format === 'csv') {
                return $this->exportCustomCSV($reportType, $data, $selectedFields, $title);
            }
            
            // Generate PDF
            $reportData['is_pdf'] = true;
            $pdf = Pdf::loadView('manage_user.mcmc_view.generate_report', $reportData);
            $pdf->setPaper('A4', 'landscape');
            
            return $pdf->download($title . '_' . date('Y-m-d_H-i-s') . '.pdf');
            
        } catch (\Exception $e) {
            Mcmc::logActivity('custom_report_error', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Error generating custom report: ' . $e->getMessage());
        }
    }
    
    /**
     * Build custom users query
     */
    private function buildCustomUsersQuery(Request $request, array $fields)
    {
        $query = User::with(['publicUser', 'agency']);
        
        // Apply filters
        if ($request->filled('status_filter')) {
            $statusValue = ucfirst($request->status_filter);
            $query->where('Status', $statusValue);
        }
        
        if ($request->filled('user_type_filter')) {
            if ($request->user_type_filter === 'public') {
                $query->where('User_Type', 'Public User');
            } elseif ($request->user_type_filter === 'agency') {
                $query->where('User_Type', 'Agency');
            }
        }
        
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        
        // Exclude MCMC users from reports
        $query->where('User_Type', '!=', 'MCMC');
        
        // Apply sorting
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);
        
        // Apply limit
        if ($request->filled('limit')) {
            $query->limit($request->limit);
        }
        
        // Get data and format for selected fields
        $users = $query->get();
        $result = [];
        
        foreach ($users as $user) {
            $row = [];
            foreach ($fields as $field) {
                switch ($field) {
                    case 'id':
                        $row['id'] = $user->User_ID;
                        break;
                    case 'name':
                        $row['name'] = $user->Name ?? 'N/A';
                        break;
                    case 'email':
                        $row['email'] = $user->Email ?? 'N/A';
                        break;
                    case 'phone':
                        $row['phone'] = $user->Contact_Number ?? 'N/A';
                        break;
                    case 'ic_number':
                        // Get IC from PublicUser table
                        $row['ic_number'] = $user->publicUser && $user->publicUser->Ic_Number 
                            ? $user->publicUser->Ic_Number 
                            : 'N/A';
                        break;
                    case 'address':
                        // Get address from Agency table if agency user, otherwise N/A
                        if ($user->User_Type === 'Agency' && $user->agency) {
                            $row['address'] = $user->agency->Address ?? 'N/A';
                        } else {
                            $row['address'] = 'N/A';
                        }
                        break;
                    case 'agency':
                        if ($user->User_Type === 'Agency' && $user->agency) {
                            $row['agency'] = $user->agency->Agency_Section ?? 'Agency User';
                        } else {
                            $row['agency'] = 'Public User';
                        }
                        break;
                    case 'status':
                        $row['status'] = strtolower($user->Status ?? 'unknown');
                        break;
                    case 'created_at':
                        $row['created_at'] = $user->created_at ? $user->created_at->format('d/m/Y H:i:s') : 'N/A';
                        break;
                }
            }
            $result[] = $row;
        }
        
        return $result;
    }
    
    /**
     * Build custom agencies query
     */
    private function buildCustomAgenciesQuery(Request $request, array $fields)
    {
        $query = Agency::with('user');
        
        // Apply filters
        if ($request->filled('status_filter')) {
            $statusValue = ucfirst($request->status_filter);
            // Filter by user status since Agency doesn't have Status field
            $query->whereHas('user', function($q) use ($statusValue) {
                $q->where('Status', $statusValue);
            });
        }
        
        if ($request->filled('start_date')) {
            $query->whereDate('Register_Date', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('Register_Date', '<=', $request->end_date);
        }
        
        // Apply sorting
        $sortBy = $request->input('sort_by', 'Register_Date');
        if ($sortBy === 'created_at') {
            $sortBy = 'Register_Date';
        } elseif ($sortBy === 'agency_name') {
            $sortBy = 'Agency_Section'; // Using Agency_Section as the agency name
        }
        $sortOrder = $request->input('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);
        
        // Apply limit
        if ($request->filled('limit')) {
            $query->limit($request->limit);
        }
        
        // Get data and format for selected fields
        $agencies = $query->get();
        $result = [];
        
        foreach ($agencies as $agency) {
            $row = [];
            foreach ($fields as $field) {
                switch ($field) {
                    case 'id':
                        $row['id'] = $agency->Agency_ID;
                        break;
                    case 'agency_name':
                        $row['agency_name'] = $agency->Agency_Section ?? 'N/A';
                        break;
                    case 'agency_type':
                        // Since we don't have agency type in current structure, use a default
                        $row['agency_type'] = 'Government Agency';
                        break;
                    case 'contact_person':
                        // Get contact person from linked user
                        $row['contact_person'] = $agency->user ? $agency->user->Name : 'N/A';
                        break;
                    case 'email':
                        // Get email from linked user
                        $row['email'] = $agency->user ? $agency->user->Email : 'N/A';
                        break;
                    case 'phone':
                        // Get phone from linked user
                        $row['phone'] = $agency->user ? $agency->user->Contact_Number : 'N/A';
                        break;
                    case 'address':
                        $row['address'] = $agency->Address ?? 'N/A';
                        break;
                    case 'status':
                        // Get status from linked user
                        $row['status'] = $agency->user ? strtolower($agency->user->Status) : 'unknown';
                        break;
                    case 'created_at':
                        $row['created_at'] = $agency->Register_Date ? $agency->Register_Date->format('d/m/Y H:i:s') : 'N/A';
                        break;
                }
            }
            $result[] = $row;
        }
        
        return $result;
    }
    
    /**
     * Build custom system query
     */
    private function buildCustomSystemQuery(Request $request, array $fields)
    {
        $systemData = [];
        
        foreach ($fields as $field) {
            switch ($field) {
                case 'total_users':
                    // Exclude MCMC users from count
                    $systemData['total_users'] = User::where('User_Type', '!=', 'MCMC')->count();
                    break;
                case 'total_agencies':
                    $systemData['total_agencies'] = Agency::count();
                    break;
                case 'active_users':
                    $systemData['active_users'] = User::where('Status', 'Active')
                        ->where('User_Type', '!=', 'MCMC')
                        ->count();
                    break;
                case 'recent_registrations':
                    $systemData['recent_registrations'] = User::where('created_at', '>=', now()->subDays(30))
                        ->where('User_Type', '!=', 'MCMC')
                        ->count();
                    break;
                case 'system_info':
                    $systemData['system_version'] = 'MCMC System v1.0.0';
                    $systemData['php_version'] = phpversion();
                    $systemData['laravel_version'] = app()->version();
                    $systemData['database_type'] = 'MySQL';
                    $systemData['server_info'] = $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown';
                    $systemData['report_generated'] = now()->format('d/m/Y H:i:s');
                    break;
                case 'database_stats':
                    $systemData['database_stats'] = [
                        'total_users' => User::count(),
                        'public_users' => User::where('User_Type', 'Public User')->count(),
                        'agency_users' => User::where('User_Type', 'Agency')->count(),
                        'mcmc_users' => User::where('User_Type', 'MCMC')->count(),
                        'agencies' => Agency::count(),
                        'public_profiles' => PublicUser::count(),
                        'active_users' => User::where('Status', 'Active')->count(),
                        'inactive_users' => User::where('Status', '!=', 'Active')->count(),
                    ];
                    break;
            }
        }
        
        return $systemData;
    }
    
    /**
     * Export custom report as CSV
     */
    private function exportCustomCSV($reportType, $data, $fields, $title)
    {
        $filename = str_replace(' ', '_', strtolower($title)) . '_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function () use ($data, $fields, $reportType) {
            $file = fopen('php://output', 'w');
            
            // Write header row
            if ($reportType === 'system') {
                fputcsv($file, ['Metric', 'Value']);
                foreach ($data as $key => $value) {
                    if (is_array($value)) {
                        foreach ($value as $subKey => $subValue) {
                            fputcsv($file, [ucfirst(str_replace('_', ' ', $subKey)), $subValue]);
                        }
                    } else {
                        fputcsv($file, [ucfirst(str_replace('_', ' ', $key)), $value]);
                    }
                }
            } else {
                $headerRow = [];
                foreach ($fields as $field) {
                    $headerRow[] = ucfirst(str_replace('_', ' ', $field));
                }
                fputcsv($file, $headerRow);
                
                // Write data rows
                foreach ($data as $row) {
                    fputcsv($file, array_values($row));
                }
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}