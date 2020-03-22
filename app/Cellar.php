<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cellar extends Model
{

    protected $fillable = [
        'store_id','fruit_id','ton','price_ton','kg','first','second','active'
    ];

    public function fruit()
    {
        return $this->belongsTo('App\Fruit');
    }

    public function store()
    {
        return $this->belongsTo('App\Store');
    }
}
