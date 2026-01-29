<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $fillable = [
        'id',
        'name',
        'slug',
        'whatsapp',
        'status',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
