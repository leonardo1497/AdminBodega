<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DaySale extends Model
{
    protected $fillable = [
        'store_id','active'
    ];

    public function store()
    {
        return $this->belongsTo('App\Store');
    }
}
