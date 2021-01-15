<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthUser extends Model
{
    protected $table = 'users';

	protected $hidden = [
    ];

	protected $guarded = [];
}
