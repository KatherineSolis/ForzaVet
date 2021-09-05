<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    //
    protected $fillable = [
        'first_name',
        'last_name',
        'document_type',
        'document_number',
        'phone',
        'direction',
        'email',
        'status',
    ];
}
