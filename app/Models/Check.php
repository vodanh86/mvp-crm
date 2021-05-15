<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Contract;

class Check extends Model
{
    protected $table = 'check';

    protected $casts = [
        'description' =>'json',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function getDescriptionAttribute($value)
    {
        return $value;
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = json_encode(array_values($value));
    }

	protected $hidden = [
    ];

	protected $guarded = [];
}
