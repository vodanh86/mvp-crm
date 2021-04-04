<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Check extends Model
{
    protected $table = 'check';

    protected $casts = [
        'description' =>'json',
    ];

    public function getDescriptionAttribute($value)
    {
        return array_values(json_decode($value, true) ?: []);
    }

    public function setCDescriptionAttribute($value)
    {
        $this->attributes['description'] = json_encode(array_values($value));
    }

	protected $hidden = [
    ];

	protected $guarded = [];
}
