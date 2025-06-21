<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencyResponse extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'agencyresponse'; // Make sure this matches your actual table name in the database

    // Primary key
    protected $primaryKey = 'Response_ID';

    // Disable Laravel's timestamps (created_at and updated_at)
    public $timestamps = false;

    // Mass assignable fields
    protected $fillable = [
        'Assignment_ID',
        'Response_Date',
        'Agency_Comments',
        'Rejection_Reason',
        'Jurisdiction_Status',
    ];

    // Relationship: AgencyResponse belongs to Assignment
    public function assignment()
    {
        return $this->belongsTo(Assignment::class, 'Assignment_ID');
    }
}
