<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InquiryProgress extends Model
{
    use HasFactory;

    protected $table = 'inquiry_progress';

    protected $primaryKey = 'progress_id';

    protected $fillable = [
        'inquiry_id',
        'agency_id',
        'mcmc_id',
        'status',
        'update_timestamp',
        'remarks',
    ];

    public $timestamps = true;

    // ✅ Relationships

    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class, 'inquiry_id');
    }

    public function agency()
    {
        return $this->belongsTo(User::class, 'agency_id');
    }
}
