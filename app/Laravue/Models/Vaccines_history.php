<?php


namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;

class Vaccines_history extends Model
{
    //
    protected $fillable = [
        'clinic_history_id',
        'vaccines_id',
        'observation',
    ];
}
