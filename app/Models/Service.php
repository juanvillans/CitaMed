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
        'availability_json',
        'adjust_avability_json',
        'programming_slot_json',
        'booked_appointment_settings_json',
        'description',
        'fields_json',
    ];

    public function user(){

        return $this->belongsTo(User::class);
    }

    public function specialty(){

        return $this->belongsTo(Specialty::class);
    }
    
}
