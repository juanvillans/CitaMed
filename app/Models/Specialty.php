<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
    ];

    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function doctors()
    {
        return $this->belongsToMany(User::class,'services','specialty_id','user_id')
        ->withPivot(
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
            'max_reservations_per_day'
        );       
    }
}
