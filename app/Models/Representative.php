<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Representative extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'user_id',
        'profession',
        'workplace',
        'second_representative_name',
        'second_representative_last_name',
        'second_representative_ci',
        'second_representative_phone_number',
        'second_representative_email',
        'second_representative_profession',
        'second_representative_workplace',
    ];

    public $timestamps = false;


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
