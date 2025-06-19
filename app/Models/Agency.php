<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class Agency extends Model
{
    use HasFactory;

    protected $table = 'agency';
    protected $primaryKey = 'Agency_ID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'Agency_ID',
        'Agency_Section',
        'Address',
        'Website',
        'Register_Date',
        'Verification_Code',
        'Temp_Password',
        'User_ID',
    ];

    protected $casts = [
        'Register_Date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'User_ID', 'User_ID');
    }


}