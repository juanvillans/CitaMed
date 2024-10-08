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
            'id',
            'user_id',
            'specialty_id',
            'title',
            'availability_json',
            'adjust_avability_json',
            'programming_slot_json',
            'booked_appointment_settings_json',
            'description',
            'fields_json',
        );       
    }
}
