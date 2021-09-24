<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    //
    protected $fillable = [
        'name',
        'age',
        'sex',
        'weight',
        'color',
        'chip',
        'client_id',
        'specie',
        'breed',
        'castrated',
        'aggressiveness',
        'status',
    ];
}
