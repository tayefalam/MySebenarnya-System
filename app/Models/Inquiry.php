<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'description', 
        'date', 
        'status', 
        'evidence', 
        'User_ID'
    ];

    protected $casts = [
        'status' => 'boolean',
        'date' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'User_ID', 'User_ID');
    }

    public function review()
    {
        return $this->hasOne(Review::class, 'inquiries_id');
    }
}
