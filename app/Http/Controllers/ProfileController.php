<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\PublicUser;
use App\Models\Agency;

class ProfileController extends Controller
{
    public function view()
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return redirect()->route('login')->withErrors('Please log in to view your profile.');
            }
            
            // Make sure we fresh load the relationship to get latest data
            // Alternative approach: directly query the user with the relationship
            $user = User::with('publicProfile')->find($user->User_ID);
            
            return view('manage_user.publicuser_view.view_user_profile', compact('user'));
        } catch (\Exception $e) {
            Log::error('Profile view error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('user.dashboard')->withErrors('Error loading profile: ' . $e->getMessage());
        }
    }

    public function editUserProfile()
    {
        $user = Auth::user();

        if (!$user || $user->User_Type !== 'Public User') {
            return redirect()->route('login')->withErrors('Access denied.');
        }

        // Load user with public profile relationship
        $user = User::with('publicProfile')->find($user->User_ID);
        if (!$user) {
            return redirect()->route('login')->withErrors('User not found.');
        }

        return view('manage_user.publicuser_view.update_user_profile', compact('user'));
    }

    public function viewAgency()
    {
        $user = Auth::user(); // Get the authenticated user

        if (!$user) {
            return redirect()->route('login')->withErrors('Please log in to view your agency profile.');
        }

        // Fetch the agency related to the user (adjust field names as needed)
        $agency = \App\Models\Agency::where('User_ID', $user->User_ID)->first();

        // Pass both $user and $agency to the view
        return view('manage_user.agency_view.view_agency_profile', compact('user', 'agency'));
    }
    

    public function userDashboard()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->withErrors('Please log in to access your dashboard.');
        }
        
        // Load the relationship safely
        $user = User::with('publicProfile')->find($user->User_ID);
        
        return view('manage_user.publicuser_view.dashboard_user', compact('user'));
    }

    public function agencyDashboard()
    {
        $user = Auth::user();
        return view('manage_user.agency_view.dashboard_agency', compact('user'));
    }

    public function update(Request $request)
    {
        try {
            // Get the authenticated user
            $user = Auth::user();

            if (!$user) {
                return redirect()->route('login')->withErrors('User not found.');
            }

            // Debug: Log user info before processing
            Log::info('Profile update attempt', [
                'user_id' => $user->User_ID,
                'user_class' => get_class($user),
                'has_update_method' => method_exists($user, 'update')
            ]);

            // Ensure we have a fresh user instance from the database
            $freshUser = User::find($user->User_ID);
            if (!$freshUser) {
                throw new \Exception('User not found in database');
            }
            
            // Use the fresh user instance for the update
            $user = $freshUser;

            // Fetch associated public user record
            $publicUser = $user->publicProfile;

            // Clean IC Number for validation
            $inputIcNumber = $request->input('ic_number');
            $cleanedIcForValidation = str_replace('-', '', $inputIcNumber);
            $cleanedIcForValidation = substr($cleanedIcForValidation, 0, 12);

            // Validate input
            $validatedData = $request->validate([
                'name'          => 'required|string|max:255',
                'email'         => 'required|email|unique:user,Email,' . $user->User_ID . ',User_ID',
                'ic_number'     => [
                    'required',
                    'string',
                    'min:12',
                    'max:14',
                    'regex:/^[0-9]{6}-?[0-9]{2}-?[0-9]{4}$/',
                    function($attribute, $value, $fail) use ($publicUser, $cleanedIcForValidation) {
                        $existingRecord = PublicUser::where('Ic_Number', $cleanedIcForValidation)
                            ->when($publicUser, function($query) use ($publicUser) {
                                return $query->where('PublicUser_ID', '!=', $publicUser->PublicUser_ID);
                            })
                            ->first();
                        
                        if ($existingRecord) {
                            $fail('The IC number is already registered.');
                        }
                    }
                ],
                'phone_number'  => 'required|string|max:20',
                'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            // Clean IC Number - remove dashes and limit to 12 characters to fit database
            $cleanIcNumber = str_replace('-', '', $validatedData['ic_number']);
            $cleanIcNumber = substr($cleanIcNumber, 0, 12); // Limit to 12 characters

            // Verify we have a valid user instance
            if (!$user) {
                throw new \Exception('Invalid user instance - cannot update profile');
            }

            // Update main user table
            $user->update([
                'Name' => $validatedData['name'],
                'Email' => $validatedData['email'],
                'Contact_Number' => $validatedData['phone_number'],
            ]);

            // Handle profile image removal first
            if ($request->has('remove_profile_image') && $request->remove_profile_image == '1') {
                // Delete existing profile image
                if ($publicUser && $publicUser->profile_image_filename) {
                    Storage::disk('public')->delete('profile_images/' . $publicUser->profile_image_filename);
                    $publicUser->setProfileImageFilename(''); // Set to empty string instead of null
                    
                    Log::info('Profile image removed for user', [
                        'user_id' => $user->User_ID,
                        'public_user_id' => $publicUser->PublicUser_ID
                    ]);
                }
            }
            // Handle profile image upload - store filename in PublicUser table
            elseif ($request->hasFile('profile_image')) {
                Log::info('Profile image upload started', [
                    'user_id' => $user->User_ID,
                    'has_public_user' => $publicUser ? true : false
                ]);
                
                // Validate file
                $file = $request->file('profile_image');
                
                if ($file->isValid()) {
                    Log::info('File validation passed', [
                        'user_id' => $user->User_ID,
                        'original_name' => $file->getClientOriginalName(),
                        'size' => $file->getSize(),
                        'mime_type' => $file->getMimeType()
                    ]);
                    
                    // Delete old profile image if exists
                    if ($publicUser && $publicUser->profile_image_filename) {
                        $oldImagePath = 'profile_images/' . $publicUser->profile_image_filename;
                        if (Storage::disk('public')->exists($oldImagePath)) {
                            Storage::disk('public')->delete($oldImagePath);
                            Log::info('Old profile image deleted', [
                                'user_id' => $user->User_ID,
                                'old_filename' => $publicUser->profile_image_filename
                            ]);
                        }
                    }

                    $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                    
                    // Store the file using the public disk
                    $storedPath = $file->storeAs('profile_images', $filename, 'public');
                    
                    Log::info('File storage attempt', [
                        'user_id' => $user->User_ID,
                        'filename' => $filename,
                        'stored_path' => $storedPath,
                        'file_exists' => Storage::disk('public')->exists($storedPath)
                    ]);
                    
                    // Verify file was stored
                    if ($storedPath && Storage::disk('public')->exists($storedPath)) {
                        // Store filename in PublicUser table Profile_Picture field
                        if ($publicUser) {
                            $publicUser->setProfileImageFilename($filename);
                            
                            // Debug: Log what was saved
                            Log::info('Profile image updated for existing user', [
                                'user_id' => $user->User_ID,
                                'public_user_id' => $publicUser->PublicUser_ID,
                                'filename' => $filename,
                                'stored_path' => $storedPath,
                                'full_path' => storage_path('app/public/' . $storedPath)
                            ]);
                        } else {
                            // Create PublicUser record first if it doesn't exist
                            $newPublicUser = PublicUser::create([
                                'PublicUser_ID' => 'PU' . strtoupper(substr(uniqid(), -8)),
                                'Ic_Number' => $cleanIcNumber,
                                'User_ID' => $user->User_ID,
                                'Profile_Picture' => $filename, // Store filename
                            ]);
                            
                            // Debug: Log what was created
                            Log::info('New PublicUser created with profile image', [
                                'user_id' => $user->User_ID,
                                'public_user_id' => $newPublicUser->PublicUser_ID,
                                'filename' => $filename,
                                'stored_path' => $storedPath
                            ]);
                        }
                    } else {
                        Log::error('Failed to store profile image', [
                            'user_id' => $user->User_ID,
                            'filename' => $filename,
                            'stored_path' => $storedPath,
                            'storage_path' => storage_path('app/public/profile_images/'),
                            'public_path' => public_path('storage/profile_images/')
                        ]);
                        
                        return redirect()->back()->withErrors('Failed to save profile image. Please try again.')->withInput();
                    }
                } else {
                    Log::error('Invalid file upload', [
                        'user_id' => $user->User_ID,
                        'file_error' => $file->getError(),
                        'file_name' => $file->getClientOriginalName()
                    ]);
                    
                    return redirect()->back()->withErrors('Invalid file. Please select a valid image file.')->withInput();
                }
            }

            // Update or create PublicUser record for IC Number
            if ($publicUser) {
                // Update existing PublicUser record
                $publicUser->update([
                    'Ic_Number' => $cleanIcNumber,
                ]);
            } else {
                // Create new PublicUser record only if not already created during image upload
                $existingProfile = PublicUser::where('User_ID', $user->User_ID)->first();
                if (!$existingProfile) {
                    PublicUser::create([
                        'PublicUser_ID' => 'PU' . strtoupper(substr(uniqid(), -8)), // Generate unique ID
                        'Ic_Number' => $cleanIcNumber,
                        'User_ID' => $user->User_ID,
                        'Profile_Picture' => '', // Empty string to satisfy NOT NULL constraint
                    ]);
                }
            }

            // Clear any cached model data to ensure fresh data on next load
            // Refresh the user instance in the session
            $user->refresh();
            
            // Force reload the relationship to ensure fresh data
            $user->load('publicProfile');
            
            return redirect()->route('user.profile.view')->with('success', 'Profile updated successfully!');

        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Failed to update profile: ' . $e->getMessage())->withInput();
        }
    }

    public function updateAgency(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user || $user->User_Type !== 'Agency') {
                return redirect()->route('login')->withErrors('Access denied.');
            }

            // Get fresh user and agency instances
            $user = User::with('agency')->find($user->User_ID);
            if (!$user) {
                throw new \Exception('User not found in database');
            }

            $agency = $user->agency;
            if (!$agency) {
                throw new \Exception('Agency profile not found');
            }

            // Validation rules
            $rules = [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:user,Email,' . $user->User_ID . ',User_ID',
                'phone_number' => 'required|string|max:20',
                'agency_section' => 'required|string|max:255',
                'address' => 'nullable|string|max:500',
                'website' => 'nullable|url|max:255',
                'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ];

            // Add password validation only if password fields are provided
            if ($request->filled('password') || $request->filled('current_password')) {
                $rules['current_password'] = 'required|string';
                $rules['password'] = [
                    'required',
                    'string',
                    'min:8',
                    'regex:/[A-Z]/',       // At least one uppercase
                    'regex:/[a-z]/',       // At least one lowercase
                    'regex:/[0-9]/',       // At least one number
                    'regex:/[@$!%*?&#]/',  // At least one special character
                    'confirmed'            // Must match password_confirmation
                ];
            }

            $validatedData = $request->validate($rules, [
                'password.min' => 'Password must be at least 8 characters long.',
                'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character (@$!%*?&#).',
                'password.confirmed' => 'Password confirmation does not match.',
                'current_password.required' => 'Current password is required to change password.',
            ]);

            // Verify current password if password change is requested
            if ($request->filled('password')) {
                if (!Hash::check($validatedData['current_password'], $user->Password)) {
                    return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.'])->withInput();
                }
            }

            // Prepare user update data
            $userUpdateData = [
                'Name' => $validatedData['name'],
                'Email' => $validatedData['email'],
                'Contact_Number' => $validatedData['phone_number'],
            ];

            // Handle profile image upload
            if ($request->hasFile('profile_image')) {
                // Delete old profile image if exists
                if ($user->profile_image) {
                    Storage::disk('public')->delete('profile_images/' . $user->profile_image);
                }

                $file = $request->file('profile_image');
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('profile_images', $filename, 'public');
                $userUpdateData['profile_image'] = $filename;
                
                Log::info('Profile image updated', [
                    'user_id' => $user->User_ID,
                    'filename' => $filename
                ]);
            }

            // Update password if provided
            if ($request->filled('password')) {
                $userUpdateData['Password'] = Hash::make($validatedData['password']);

                // Clear temporary password if it exists
                if (!empty($agency->Temp_Password) && trim($agency->Temp_Password) !== '') {
                    $agency->Temp_Password = '';
                    Log::info('Temporary password cleared during profile update', [
                        'user_id' => $user->User_ID,
                        'agency_id' => $agency->Agency_ID
                    ]);
                }
            }

            // Update user record
            $user->update($userUpdateData);

            // Update agency table
            $agencyUpdateData = [
                'Agency_Section' => $validatedData['agency_section'],
                'Address' => $validatedData['address'] ?? '',
                'Website' => $validatedData['website'] ?? '',
            ];

            $agency->update($agencyUpdateData);

            Log::info('Agency profile updated successfully', [
                'user_id' => $user->User_ID,
                'agency_id' => $agency->Agency_ID,
                'password_changed' => $request->filled('password')
            ]);

            $successMessage = 'Agency profile updated successfully!';
            if ($request->filled('password')) {
                $successMessage .= ' Password has been changed.';
            }

            return redirect()->route('view.agency.profile')->with('success', $successMessage);

        } catch (ValidationException $e) {
            Log::error('Agency profile validation failed', [
                'user_id' => Auth::id(),
                'errors' => $e->errors()
            ]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Agency profile update failed', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->withErrors('Failed to update profile: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show the password change form for agencies with temporary passwords
     */
    public function showChangePasswordForm()
    {
        $user = Auth::user();

        if ($user->User_Type !== 'Agency') {
            return redirect()->route('login')->withErrors('Access denied.');
        }

        // Check if user has a temporary password
        $agency = $user->agency;
        if (!$agency || empty($agency->Temp_Password) || trim($agency->Temp_Password) === '') {
            // If no temp password, redirect to dashboard
            return redirect()->route('agency.dashboard')
                ->with('info', 'No password change required.');
        }

        return view('manage_user.agency_view.change_password');
    }

    /**
     * Handle password change for agencies with temporary passwords
     */
    public function changePassword(Request $request)
    {
        Log::info('Password change attempt started', [
            'user_id' => Auth::id(),
            'request_data' => $request->except(['password', 'password_confirmation'])
        ]);

        $user = Auth::user();

        if ($user->User_Type !== 'Agency') {
            Log::warning('Non-agency user attempted password change', ['user_type' => $user->User_Type]);
            return redirect()->route('login')->withErrors('Access denied.');
        }

        try {
            // Validate the new password with strong requirements
            $validatedData = $request->validate([
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/[A-Z]/',       // At least one uppercase
                    'regex:/[a-z]/',       // At least one lowercase
                    'regex:/[0-9]/',       // At least one number
                    'regex:/[@$!%*?&#]/',  // At least one special character
                    'confirmed'            // Must match password_confirmation
                ],
            ], [
                'password.min' => 'Password must be at least 8 characters long.',
                'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character (@$!%*?&#).',
                'password.confirmed' => 'Password confirmation does not match.',
            ]);

            Log::info('Password validation passed');

            // Load agency relationship
            $agency = $user->agency;
            if (!$agency) {
                Log::error('Agency relationship not found', ['user_id' => $user->User_ID]);
                return back()->withErrors('Agency profile not found. Please contact support.');
            }

            if (empty($agency->Temp_Password) || trim($agency->Temp_Password) === '') {
                Log::info('No temporary password found, redirecting to dashboard');
                return redirect()->route('agency.dashboard')
                    ->with('info', 'No password change required.');
            }

            Log::info('About to update password', [
                'user_id' => $user->User_ID,
                'agency_id' => $agency->Agency_ID,
                'has_temp_password' => !empty($agency->Temp_Password)
            ]);

            // Get fresh user instance from database to ensure we have a proper Eloquent model
            $freshUser = User::find($user->User_ID);
            if (!$freshUser) {
                throw new \Exception('User not found in database');
            }

            // Update main password using the update method
            $userSaved = $freshUser->update([
                'Password' => Hash::make($validatedData['password'])
            ]);

            Log::info('User password update result', ['saved' => $userSaved]);

            // Clear temporary password (set to empty string due to NOT NULL constraint)
            $agencySaved = $agency->update([
                'Temp_Password' => ''
            ]);

            Log::info('Agency temp password clear result', ['saved' => $agencySaved]);

            Log::info('Agency password changed successfully', [
                'user_id' => $user->User_ID,
                'agency_id' => $agency->Agency_ID
            ]);

            return redirect()->route('agency.dashboard')
                ->with('success', 'Password changed successfully! Welcome to your dashboard.');

        } catch (ValidationException $e) {
            Log::error('Password validation failed', [
                'user_id' => $user->User_ID,
                'errors' => $e->errors()
            ]);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Password change failed with exception', [
                'user_id' => $user->User_ID,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withErrors('Failed to change password: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Z]/',       // At least one uppercase
                'regex:/[a-z]/',       // At least one lowercase
                'regex:/[0-9]/',       // At least one number
                'regex:/[@$!%*?&#]/',  // At least one special character
                'confirmed'            // Must match password_confirmation
            ],
        ]);

        $user = Auth::user();

        if ($user->User_Type !== 'Agency') {
            return back()->withErrors(['not_allowed' => 'Only agency users can update password here.']);
        }

        // Get fresh user instance from database to ensure we have a proper Eloquent model
        $freshUser = User::with('agency')->find($user->User_ID);
        if (!$freshUser) {
            return back()->withErrors(['error' => 'User not found in database.']);
        }

        // Update main password using the update method
        $freshUser->update([
            'Password' => Hash::make($request->password)
        ]);

        // Clear Temp_Password (set to empty string due to NOT NULL constraint)
        if ($freshUser->agency) {
            $freshUser->agency->update([
                'Temp_Password' => ''
            ]);
        }

        return redirect()->route('view.agency.profile')->with('password_success', 'Password updated successfully!');
    }

    public function destroy($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();

        return redirect()->route('mcmc.dashboard')->with('success', 'User deleted successfully.');
    }

    public function editAgencyProfile()
    {
        $user = Auth::user();

        if (!$user || $user->User_Type !== 'Agency') {
            return redirect()->route('login')->withErrors('Access denied.');
        }

        // Load user with agency relationship
        $user = User::with('agency')->find($user->User_ID);
        if (!$user) {
            return redirect()->route('login')->withErrors('User not found.');
        }

        $agency = $user->agency;
        if (!$agency) {
            return redirect()->route('agency.dashboard')->withErrors('Agency profile not found.');
        }

        return view('manage_user.agency_view.update_agency_profile', compact('user', 'agency'));
    }


}