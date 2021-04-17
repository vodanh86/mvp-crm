<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $table = 'contracts';

    public function getSaleIdAttribute($value)
    {
        return array_values(json_decode($value, true) ?: []);
    }

    public function setSaleIdAttribute($value)
    {
        $this->attributes['sale_id'] = json_encode(array_values($value));
    }

	protected $hidden = [
    ];

	protected $guarded = [];
}
