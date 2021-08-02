<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    //
    protected $fillable = [
        'name',
        'breed_id',
        'observation',
        'status'
    ];
}
