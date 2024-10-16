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
        'duration_per_appointment',
        'duration_options',
        'availability',
        'adjusted_availability',
        'programming_slot',
        'booked_appointment_settings',
        'description',
        'fields',
    ];

    public function user(){

        return $this->belongsTo(User::class);
    }

    public function specialty(){

        return $this->belongsTo(Specialty::class);
    }

    public function appointments(){

        return $this->hasMany(Appointment::class);
    }
    
}
