<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = [
<<<<<<< HEAD
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
=======
        'title',
        'description',
        'date',
        'status',
        'evidence',
        'user_id',
    ];
>>>>>>> a475ae09d5e7d0662df260e489df6e852d566804
}
