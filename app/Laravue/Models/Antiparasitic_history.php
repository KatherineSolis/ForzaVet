<?php


namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;

class Antiparasitic_history extends Model
{
    //
    protected $fillable = [
        'clinic_history_id',
        'antiparasitic_id',
        'weight',
        'observation',
    ];
}
