<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'code',
    ];

    protected $hidden = [
        'id',
        'code',
        'created_at',
        'updated_at',
    ];

}
