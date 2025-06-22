<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'user';
    
    protected $primaryKey = 'User_ID';
    public $incrementing = false;
    protected $keyType = 'string';



    use HasFactory, Notifiable;

    protected $fillable = [
        'User_ID', 
        'Name', 
        'Email', 
        'Password', 
        'Contact_Number', 
        'User_Type', 
        'Status',
        'profile_image',
        'reset_token',
        'reset_token_expires_at',
    ];

    protected $hidden = [
        'Password', 'remember_token', 'reset_token',
    ];


    protected $casts = [
        'reset_token_expires_at' => 'datetime',
    ];

    public function getAuthIdentifierName()


    {
        return 'User_ID';
    }


    public function getAuthPassword()
    {
        return $this->Password;
    }

    // Link to publicuser details
    public function publicUser()
    {
        return $this->hasOne(PublicUser::class, 'User_ID', 'User_ID');
    }
    
    // Alias for backward compatibility
    public function publicProfile()
    {
        return $this->publicUser();
    }

    // Link to agency details
    public function agency()
    {
        return $this->hasOne(Agency::class, 'User_ID', 'User_ID');
    }

    /**
     * Get profile image filename from PublicUser table
     */
    public function getProfileImageAttribute()
    {
        return $this->publicUser ? $this->publicUser->profile_image_filename : null;
    }

    /**
     * Generate and store password reset token
     */
    public function generatePasswordResetToken()
    {
        $token = \Illuminate\Support\Str::random(64);
        
        $this->update([
            'reset_token' => \Illuminate\Support\Facades\Hash::make($token),
            'reset_token_expires_at' => now()->addMinutes(60), // Token expires in 60 minutes
        ]);
        
        return $token; // Return the plain token for the reset URL
    }

    /**
     * Check if reset token is valid
     */
    public function isValidResetToken($token)
    {
        if (!$this->reset_token || !$this->reset_token_expires_at) {
            return false;
        }

        // Check if token has expired
        if (now()->isAfter($this->reset_token_expires_at)) {
            return false;
        }

        // Check if token matches
        return \Illuminate\Support\Facades\Hash::check($token, $this->reset_token);
    }

    /**
     * Clear password reset token
     */
    public function clearPasswordResetToken()
    {
        $this->update([
            'reset_token' => null,
            'reset_token_expires_at' => null,
        ]);
    }

    /**
     * Check if user has an active reset token
     */
    public function hasActiveResetToken()
    {
        return $this->reset_token && 
               $this->reset_token_expires_at && 
               now()->isBefore($this->reset_token_expires_at);
    }


    // ✅ Add this method below
    public function progressEntries()
    {
        return $this->hasMany(InquiryProgress::class, 'agency_id');
    }

}
