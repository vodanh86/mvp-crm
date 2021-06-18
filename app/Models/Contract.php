<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $table = 'contracts';

    public function bills() {
        return $this->hasMany(Bill::class,'contract_id');
    }

    public function getSaleIdAttribute($value)
    {
        return array_values(json_decode($value, true) ?: []);
    }

    public function setSaleIdAttribute($value)
    {
        $this->attributes['sale_id'] = json_encode(array_values($value));
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }

	protected $hidden = [
    ];

	protected $guarded = [];
}
