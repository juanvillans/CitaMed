<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specialty_id',
        'title',
        'description',
        'duration_per_appointment',
        'schedule_json',
        'start_date_agenda',
        'end_date_agenda',
        'max_reservation_time_before_appointment',
        'min_reservation_time_before_appointment',
        'adjust_avability_json',
        'duration_between_appointment',
        'max_reservations_per_day',
    ];

    public function user(){

        return $this->belongsTo(User::class);
    }

    public function specialty(){

        return $this->belongsTo(Specialty::class);
    }
    
}
