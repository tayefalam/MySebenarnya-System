<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'status', 'inquiries_id', 'user_id'
    ];

    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class, 'inquiries_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'User_ID', 'User_ID');
    }
}
