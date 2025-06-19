<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('manage_user.login_view.login_user');
    }

    public function login(Request $request)
    {
        Log::info('Login attempt started', [
            'email' => $request->email,
            'user_type' => $request->user_type,
            'has_password' => !empty($request->password)
        ]);

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'user_type' => 'required|in:public_user,agency,mcmc',
        ]);

        $expectedType = match ($request->user_type) {
            'public_user' => 'Public User',
            'agency' => 'Agency',
            'mcmc' => 'MCMC',
        };

        Log::info('Expected user type: ' . $expectedType);

        $user = User::where('Email', $request->email)->first();

        if (!$user) {
            Log::warning('User not found', ['email' => $request->email]);
            return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
        }

        Log::info('User found', [
            'user_id' => $user->User_ID,
            'user_type' => $user->User_Type,
            'status' => $user->Status
        ]);

        // Check both main password and temporary password for agencies
        $passwordValid = false;
        if (Hash::check($request->password, $user->Password)) {
            $passwordValid = true;
        } elseif ($user->User_Type === 'Agency' && $user->agency && !empty($user->agency->Temp_Password) && trim($user->agency->Temp_Password) !== '') {
            // Check if the provided password matches the temporary password
            if (Hash::check($request->password, $user->agency->Temp_Password)) {
                $passwordValid = true;
                Log::info('Login with temporary password detected', ['email' => $request->email]);
            }
        }

        if (!$passwordValid) {
            Log::warning('Password check failed', ['email' => $request->email]);
            return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
        }

        Log::info('Password check passed');

        if ($user->User_Type !== $expectedType) {
            Log::warning('User type mismatch', [
                'expected' => $expectedType,
                'actual' => $user->User_Type
            ]);
            return back()->withErrors(['user_type' => 'Incorrect user type selected.'])->withInput();
        }

        if ($user->Status !== 'Active') {
            Log::warning('User account inactive', ['status' => $user->Status]);
            return back()->withErrors(['status' => 'Account is inactive.'])->withInput();
        }

        Log::info('All validation checks passed');

        Auth::login($user);
        $request->session()->regenerate();

        // 🔐 Force redirect to change password if Temp_Password still exists
        if ($user->User_Type === 'Agency') {
            $agency = $user->agency;
            if ($agency && !empty($agency->Temp_Password) && trim($agency->Temp_Password) !== '') {
                Log::info('Redirecting agency to change password - temp password detected');
                return redirect()->route('agency.change.password')
                    ->with('warning', 'You must change your temporary password before accessing the system.');
            }
        }

        if (Auth::check()) {
            Log::info('Authentication successful', [
                'authenticated_user_id' => Auth::id(),
                'authenticated_user_type' => Auth::user()->User_Type,
                'session_id' => session()->getId(),
                'session_data' => session()->all()
            ]);
        } else {
            Log::error('Authentication failed after Auth::login()');
            return back()->withErrors(['login' => 'Authentication failed. Please try again.'])->withInput();
        }

        return $this->authenticated($request, $user);
    }

    protected function authenticated(Request $request, $user)
    {
        Log::info('Starting redirect process', [
            'user_type' => $user->User_Type,
            'user_id' => $user->User_ID,
            'is_authenticated' => Auth::check()
        ]);

        try {
            $redirectRoute = match ($user->User_Type) {
                'Public User' => 'user.dashboard',
                'Agency' => 'agency.dashboard',
                'MCMC' => 'mcmc.dashboard',
                default => null,
            };

            Log::info('Determined redirect route', [
                'route_name' => $redirectRoute,
                'user_type' => $user->User_Type
            ]);

            if ($redirectRoute && Route::has($redirectRoute)) {
                return redirect()->route($redirectRoute)
                    ->with('welcome', 'Welcome to Dashboard, ' . $user->Name . '!');
            } else {
                Log::error('Route not found or user type not recognized', [
                    'user_type' => $user->User_Type,
                    'attempted_route' => $redirectRoute,
                    'route_exists' => $redirectRoute ? Route::has($redirectRoute) : false
                ]);
                return redirect()->route('login')->withErrors([
                    'user_type' => 'User type not recognized: ' . $user->User_Type
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Redirect failed with exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_type' => $user->User_Type,
                'user_id' => $user->User_ID
            ]);
            return redirect()->route('login')->withErrors([
                'redirect' => 'Unable to redirect to dashboard. Error: ' . $e->getMessage()
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}