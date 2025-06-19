<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Agency;
use App\Models\Mcmc;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use App\Mail\AgencyCredentialsMail;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('manage_user.login_view.register_user');
    }

    public function register(Request $request)
    {
        // Rate limiting
        $key = 'register.' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return redirect()->back()->withErrors(['error' => "Too many registration attempts. Please try again in {$seconds} seconds."])->withInput();
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:user,Email',
            'phone_number' => 'required|string|max:20',
            'password' => 'required|string|min:7|confirmed',
            'user_type' => 'required|in:public_user,agency,mcmc',
        ]);

        RateLimiter::hit($key, 300); // 5 minutes

        try {
            $userID = $this->generateUniqueUserId();
            
            User::create([
                'User_ID' => $userID,
                'Name' => $request->name,
                'Email' => $request->email,
                'Password' => Hash::make($request->password),
                'Contact_Number' => $request->phone_number,
                'User_Type' => match ($request->user_type) {
                    'public_user' => 'Public User',
                    'agency' => 'Agency',
                    'mcmc' => 'MCMC',
                },
                'Status' => 'Active'
            ]);
        } catch (\Exception $e) {
            Log::error('User registration failed: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Registration failed. Please try again.'])->withInput();
        }

        return redirect()->route('login')->with('success', 'Registration successful. Please login.');
    }

    public function showAgencyRegistrationForm()
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
        Mcmc::logActivity('agency_registration_form_access');

        return view('manage_user.mcmc_view.register_agency');
    }

    public function registerAgency(Request $request)
    {
        try {
            // Check if user is authenticated
            if (!Auth::check()) {
                return redirect()->route('login')->withErrors(['error' => 'Please login first']);
            }

            // Validate MCMC access
            if (!Mcmc::validateMcmcAccess(Auth::user())) {
                return redirect()->route('login')->withErrors(['error' => 'Unauthorized access']);
            }
            // Validate the request using helper method
            $this->validateAgencyData($request);

            // Generate unique IDs and credentials
            $userID = $this->generateUniqueUserId();
            $agencyID = $this->generateUniqueAgencyId();
            $verificationCode = strtoupper(Str::random(6));
            
            // Username is no longer needed - agencies will login with email
            
            // Generate secure random password
            $generatedPassword = $this->generateSecurePassword();

            // Use database transaction for data integrity
            DB::beginTransaction();

            try {
                // Create User record
                $user = User::create([
                    'User_ID' => $userID,
                    'Name' => $request->agency_name,
                    'Email' => $request->agency_email,
                    'Password' => Hash::make($generatedPassword),
                    'Contact_Number' => $request->agency_phone,
                    'User_Type' => 'Agency',
                    'Status' => 'Active'
                ]);

                // Create Agency record
                $agency = Agency::create([
                    'Agency_ID' => $agencyID,
                    'Agency_Section' => $request->agency_section,
                    'Address' => $request->agency_address,
                    'Website' => $request->agency_website ?? '',
                    'Register_Date' => now(),
                    'Verification_Code' => $verificationCode,
                    'Temp_Password' => $generatedPassword, // Store for reference
                    'User_ID' => $userID,
                ]);

                // Commit the transaction
                DB::commit();

                // Send email with login credentials (after successful database operations)
                $this->sendAgencyCredentials($request->agency_email, $request->agency_name, $generatedPassword, $agencyID);

                // Log successful agency registration
                Mcmc::logActivity('agency_registered', [
                    'agency_id' => $agencyID,
                    'agency_name' => $request->agency_name,
                    'agency_email' => $request->agency_email,
                    'user_id' => $userID,
                ]);

            } catch (\Exception $e) {
                // Rollback the transaction on error
                DB::rollback();
                throw $e;
            }

            return redirect()->route('mcmc.register.agency')->with('success', 
                'Agency registered successfully! Login credentials have been sent to ' . $request->agency_email . 
                '. Please check your email (including spam folder). Agency ID: ' . $agencyID
            );

        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Agency registration failed: ' . $e->getMessage(), [
                'agency_name' => $request->agency_name ?? 'unknown',
                'agency_email' => $request->agency_email ?? 'unknown',
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()->withErrors(['error' => 'Failed to register agency: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Generate a secure random password
     */
    private function generateSecurePassword($length = 12)
    {
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '0123456789';
        $symbols = '!@#$%&*';
        
        // Ensure at least one character from each set
        $password = '';
        $password .= $uppercase[random_int(0, strlen($uppercase) - 1)];
        $password .= $lowercase[random_int(0, strlen($lowercase) - 1)];
        $password .= $numbers[random_int(0, strlen($numbers) - 1)];
        $password .= $symbols[random_int(0, strlen($symbols) - 1)];
        
        // Fill the rest with random characters
        $allChars = $uppercase . $lowercase . $numbers . $symbols;
        for ($i = 4; $i < $length; $i++) {
            $password .= $allChars[random_int(0, strlen($allChars) - 1)];
        }
        
        // Shuffle the password
        return str_shuffle($password);
    }

    /**
     * Send login credentials via email
     */
    private function sendAgencyCredentials($email, $agencyName, $password, $agencyId)
    {
        try {
            Mail::to($email)->send(new AgencyCredentialsMail($agencyName, $email, $password, $agencyId));
            Log::info('Agency credentials email sent successfully to: ' . $email);
        } catch (\Exception $e) {
            // Log the error but don't fail the registration
            Log::error('Failed to send agency credentials email to ' . $email . ': ' . $e->getMessage());
            
            // You could also add email to a failed queue for retry
            // Or send notification to admin about failed email
        }
    }

    /**
     * View all registered users (agencies & public users) with their credentials (MCMC Admin only)
     */
    public function viewRegisteredUsers()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors(['error' => 'Please login first']);
        }

        // Check if user is MCMC admin
        if (!Mcmc::validateMcmcAccess(Auth::user())) {
            return redirect()->route('mcmc.dashboard')->withErrors(['error' => 'Unauthorized access.']);
        }

        // Log activity
        Mcmc::logActivity('view_registered_users');

        // Get all users (except MCMC) with their agency relationships
        $users = Mcmc::getRegisteredUsers();
        return view('manage_user.mcmc_view.view_registered_user', compact('users'));
    }

    /**
     * Resend credentials to agency via email
     */
    public function resendCredentials($agencyId)
    {
        try {
            // Check if user is authenticated
            if (!Auth::check()) {
                return redirect()->route('login')->withErrors(['error' => 'Please login first']);
            }

            // Check if user is MCMC admin
            if (!Mcmc::validateMcmcAccess(Auth::user())) {
                return back()->withErrors(['error' => 'Unauthorized access.']);
            }

            $agency = Agency::with('user')->findOrFail($agencyId);
            
            // Check if agency has valid credentials
            if (!$agency->Temp_Password) {
                return back()->withErrors(['error' => 'Agency credentials not found. Please contact admin.']);
            }
            
            // Send email with credentials
            $this->sendAgencyCredentials(
                $agency->user->Email,
                $agency->user->Name,
                $agency->Temp_Password,
                $agency->Agency_ID
            );

            // Log the credential resend activity
            Mcmc::logActivity('credentials_resent', [
                'agency_id' => $agencyId,
                'agency_name' => $agency->user->Name,
                'email' => $agency->user->Email,
            ]);

            return back()->with('success', 'Credentials resent successfully to ' . $agency->user->Email);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to resend credentials: ' . $e->getMessage()]);
        }
    }

    /**
     * Handle database schema changes for removing username
     * This method can be called to update the database structure
     */
    public function updateAgencySchema()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return response()->json(['error' => 'Please login first'], 401);
        }

        // Check if user is MCMC admin
        if (Auth::user()->User_Type !== 'MCMC') {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }

        try {
            $result = Agency::removeUsernameColumn();
            
            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'Username column removed successfully from agency table'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Username column was already removed or does not exist'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Schema update failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update schema: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Rollback schema changes (restore username column)
     * This method can restore the username column if needed
     */
    public function rollbackAgencySchema()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return response()->json(['error' => 'Please login first'], 401);
        }

        // Check if user is MCMC admin
        if (Auth::user()->User_Type !== 'MCMC') {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }

        try {
            $result = Agency::addUsernameColumn();
            
            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'Username column restored successfully to agency table'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Username column already exists in agency table'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Schema rollback failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to rollback schema: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the MCMC dashboard with real statistics
     */
    public function mcmcDashboard()
    {
        try {
            // Check if user is authenticated
            if (!Auth::check()) {
                return redirect()->route('login')->withErrors(['error' => 'Please login first']);
            }

            // Validate MCMC access
            if (!Mcmc::validateMcmcAccess(Auth::user())) {
                return redirect()->route('login')->withErrors(['error' => 'Unauthorized access']);
            }

            // Log activity
            Mcmc::logActivity('dashboard_access');

            // Get dashboard statistics from MCMC model
            $stats = Mcmc::getDashboardStats();
            $totalUsers = $stats['totalUsers'];
            $totalAgencies = $stats['totalAgencies'];
            $activeSessions = $stats['activeSessions'];
            
            // Get current user's name
            $adminName = Auth::user()->Name ?? 'Admin';
            
            return view('manage_user.mcmc_view.dashboard_mcmc', compact('totalUsers', 'totalAgencies', 'activeSessions', 'adminName'));
            
        } catch (\Exception $e) {
            Log::error('MCMC Dashboard Error: ' . $e->getMessage());
            // Fallback data if database queries fail
            return view('manage_user.mcmc_view.dashboard_mcmc', [
                'totalUsers' => 0,
                'totalAgencies' => 0,
                'activeSessions' => 0,
                'adminName' => 'Admin'
            ]);
        }
    }

    /**
     * Display MCMC admin profile (view only)
     */
    public function mcmcProfile()
    {
        try {
            // Check if user is authenticated
            if (!Auth::check()) {
                return redirect()->route('login')->withErrors(['error' => 'Please login first']);
            }

            // Validate MCMC access
            if (!Mcmc::validateMcmcAccess(Auth::user())) {
                return redirect()->route('login')->withErrors(['error' => 'Unauthorized access']);
            }

            $user = Auth::user();
            
            // Get profile data from MCMC model
            $profileData = Mcmc::getMcmcProfile($user);
            
            if (!$profileData) {
                return redirect()->route('login')->withErrors(['error' => 'Unauthorized access']);
            }

            // Log activity
            Mcmc::logActivity('profile_access');
            
            // Extract data
            $totalUsersManaged = $profileData['totalUsersManaged'];
            $totalAgenciesManaged = $profileData['totalAgenciesManaged'];
            $lastLoginDate = $profileData['lastLoginDate'];
            
            return view('manage_user.mcmc_view.mcmc_profile', compact('user', 'totalUsersManaged', 'totalAgenciesManaged', 'lastLoginDate'));
            
        } catch (\Exception $e) {
            Log::error('MCMC Profile Error: ' . $e->getMessage());
            return redirect()->route('mcmc.dashboard')->withErrors(['error' => 'Failed to load profile: ' . $e->getMessage()]);
        }
    }

    /**
     * Generate unique user ID
     */
    private function generateUniqueUserId()
    {
        do {
            $userID = 'USR' . strtoupper(Str::random(7));
        } while (!Mcmc::isUserIdUnique($userID));
        
        return $userID;
    }

    /**
     * Generate unique agency ID
     */
    private function generateUniqueAgencyId()
    {
        do {
            $agencyID = 'AG' . strtoupper(substr(uniqid(), -8));
        } while (!Mcmc::isAgencyIdUnique($agencyID));
        
        return $agencyID;
    }

    /**
     * Validate agency registration data
     */
    private function validateAgencyData(Request $request)
    {
        $rules = [
            'agency_name' => 'required|string|max:255',
            'agency_section' => 'required|string|max:100',
            'agency_email' => 'required|email|unique:user,Email',
            'agency_phone' => 'required|string|max:20',
            'agency_address' => 'required|string|max:200',
            'agency_website' => 'nullable|url|max:100',
        ];

        $messages = [
            'agency_name.required' => 'Agency name is required.',
            'agency_email.unique' => 'This email is already registered.',
            'agency_email.email' => 'Please enter a valid email address.',
            'agency_phone.required' => 'Agency phone number is required.',
            'agency_address.required' => 'Agency address is required.',
            'agency_website.url' => 'Please enter a valid website URL.',
        ];

        return $request->validate($rules, $messages);
    }
}
