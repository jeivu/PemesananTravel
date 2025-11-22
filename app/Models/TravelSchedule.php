<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TravelSchedule extends Model
{
    protected $fillable = [
        'destination',
        'departure_date',
        'departure_time',
        'total_quota',
        'available_quota',
        'price',
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'schedule_id');
    }
}
