<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'time_id',
        'user_id',
        'specialist_id',
        'service_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function specialist()
    {
        return $this->belongsTo(Specialist::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
