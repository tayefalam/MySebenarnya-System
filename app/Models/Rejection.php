<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rejection extends Model
{
    use HasFactory;

    protected $table = 'rejections'; // Make sure this matches your actual table name

    public $timestamps = false;

    protected $fillable = [
        'Assignment_ID',
        'Inquiry_ID',
        'Rejection_Reason',
        'Agency_Comments',
    ];

    // Relationships (optional)
    public function assignment()
    {
        return $this->belongsTo(Assignment::class, 'Assignment_ID');
    }

    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class, 'Inquiry_ID');
    }
}
