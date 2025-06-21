<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $table = 'Assignment';
    protected $primaryKey = 'Assignment_ID';
    public $timestamps = false;

    protected $fillable = [
        'Inquiry_ID',
        'MCMC_ID',
        'Agency_ID',
        'Assigned_Date',
        'Reassigned',
    ];

    // Relationships for report
    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class, 'Inquiry_ID', 'Inquiry_ID');
    }


    public function agency()
    {
        return $this->belongsTo(Agency::class, 'Agency_ID', 'Agency_ID');
    }

    public function mcmc()
    {
        return $this->belongsTo(MCMC::class, 'MCMC_ID', 'MCMC_ID');
    }
}
