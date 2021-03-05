<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gfp extends Model
{
    protected $table = 'gfp';

    protected $hidden = [];

    protected $guarded = [];

    protected $casts = [
        'target' =>'json',
    ];

}
