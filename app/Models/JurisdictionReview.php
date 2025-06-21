<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurisdictionReview extends Model
{
    use HasFactory;

    protected $table = 'jurisdiction_reviews'; // Make sure this matches your table name

    protected $primaryKey = 'Response_ID';

    public $timestamps = false;

    protected $fillable = [
        'Assignment_ID',
        'Inquiry_ID',
        'Jurisdiction_Status',
        'Response_Date',
        'Agency_Comments',
    ];

    // Relationships if needed (optional)
    public function assignment()
    {
        return $this->belongsTo(Assignment::class, 'Assignment_ID');
    }

    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class, 'Inquiry_ID');
    }
}
