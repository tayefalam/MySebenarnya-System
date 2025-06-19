<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    /**
     * Show the forgot password form
     */
    public function showForgotPasswordForm()
    {
        return view('manage_user.login_view.forgotPassword');
    }

    /**
     * Send password reset link
     */
    public function sendResetLink(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:user,Email',
        ], [
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.exists' => 'We could not find a user with that email address.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::where('Email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'We could not find a user with that email address.']);
        }

        // Generate reset token using the User model method
        $token = $user->generatePasswordResetToken();

        // Create the reset URL
        $resetUrl = route('password.reset', ['token' => $token, 'email' => $request->email]);

        // For now, we'll display the reset link instead of sending email
        // In production, you would send an email with the reset link
        return back()->with('success', 'Password reset link has been generated successfully! Please copy this link: ' . $resetUrl);
    }

    /**
     * Show the password reset form
     */
    public function showResetForm(Request $request, $token = null)
    {
        if (!$token || !$request->email) {
            return redirect()->route('password.request')->withErrors(['token' => 'Invalid reset link.']);
        }

        // Verify that the user exists and has a valid token
        $user = User::where('Email', $request->email)->first();
        
        if (!$user || !$user->isValidResetToken($token)) {
            return redirect()->route('password.request')->withErrors(['token' => 'This password reset token is invalid or has expired.']);
        }

        return view('manage_user.login_view.resetPassword', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    /**
     * Reset the password
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email|exists:user,Email',
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
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character (@$!%*?&#).',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput($request->except('password', 'password_confirmation'));
        }

        // Find the user
        $user = User::where('Email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'User not found.']);
        }

        // Validate the reset token
        if (!$user->isValidResetToken($request->token)) {
            return back()->withErrors(['token' => 'This password reset token is invalid or has expired.']);
        }

        // Update user password
        $user->update([
            'Password' => Hash::make($request->password)
        ]);

        // Clear the reset token
        $user->clearPasswordResetToken();

        return redirect()->route('login')->with('success', 'Your password has been reset successfully! You can now login with your new password.');
    }

    /**
     * Clean up expired tokens (can be called via scheduled task)
     */
    public function cleanupExpiredTokens()
    {
        User::where('reset_token_expires_at', '<', now())
            ->whereNotNull('reset_token')
            ->update([
                'reset_token' => null,
                'reset_token_expires_at' => null
            ]);
    }
}