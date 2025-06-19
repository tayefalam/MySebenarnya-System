<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicUser extends Model
{
    protected $table = 'publicuser';
    protected $primaryKey = 'PublicUser_ID';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'PublicUser_ID',
        'User_ID',
        'Ic_Number',
        'Profile_Picture',
    ];

    /**
     * Get the associated user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'User_ID', 'User_ID');
    }

    /**
     * Get formatted IC Number with dashes
     */
    public function getFormattedIcNumberAttribute()
    {
        if (!$this->Ic_Number || strlen($this->Ic_Number) < 12) {
            return $this->Ic_Number;
        }
        
        // Format 12-digit IC: 123456789012 -> 123456-78-9012
        return substr($this->Ic_Number, 0, 6) . '-' . 
               substr($this->Ic_Number, 6, 2) . '-' . 
               substr($this->Ic_Number, 8, 4);
    }

    /**
     * Get profile image filename from Profile_Picture field
     * We'll store filename as text in the Profile_Picture field
     */
    public function getProfileImageFilenameAttribute()
    {
        // Return the filename if it exists and looks like a filename
        if ($this->Profile_Picture) {
            // Check if it looks like a filename (has an extension)
            if (preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $this->Profile_Picture)) {
                return $this->Profile_Picture;
            }
        }
        return null;
    }

    /**
     * Set profile image filename in Profile_Picture field
     */
    public function setProfileImageFilename($filename)
    {
        $this->Profile_Picture = $filename;
        $this->save();
    }

    /**
     * Check if data is binary (simple check)
     */
    private function isBinaryData($data)
    {
        // Simple check: if it contains common image file extensions, it's probably a filename
        // Return true if it's binary (does NOT match filename pattern)
        return !preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $data);
    }
}
