<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = [
        'inquiry_id',
        'agency_id',
        'mcmc_id',
        'message',
        'is_read',
    ];

    public $timestamps = true;
}
