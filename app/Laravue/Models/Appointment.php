<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    //
    protected $fillable = [
        'registration_date',
        'hours',
        'duration',
        'end',
        'description',
        'personal_id',
        'pet_id',
        'client_id',
        'status',
        'status_button',
    ];
}
