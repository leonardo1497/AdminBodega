<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'customer_id','seller_id','seller_delivery_id','day_sale_id', 'type_pay', 'fruits', 'pays','total', 'pay'
    ];

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function seller()
    {
        return $this->belongsTo('App\Seller');
    }

    public function delivery()
    {
        return $this->belongsTo('App\Seller');
    }

    public function daySale()
    {
        return $this->belongsTo('App\DaySale');
    }
}
