<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;

class Clinic_history extends Model
{
    //
    protected $fillable = [
        'date',
        'personal_id',
        'client_id',
        'pet_id',
        'reason',
        'anamnesis',
        'diagnostic',
        'pathology',
        'treatment',
        'prescription',
    ];
}
