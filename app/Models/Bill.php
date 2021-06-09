<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $table = 'bills';

    public function getSaleIdAttribute($value)
    {
        return array_values(json_decode($value, true) ?: []);
    }

    public function setSaleIdAttribute($value)
    {
        $this->attributes['sale_id'] = json_encode(array_values($value));
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class,'contract_id');
    }

    /*public function getContractIdAttribute($value)
    {
        return array_values(json_decode($value, true) ?: []);
    }

    public function setContractIdAttribute($value)
    {
        $this->attributes['contract_id'] = json_encode(array_values($value));
    }*/

	protected $hidden = [
    ];

	protected $guarded = [];
}
