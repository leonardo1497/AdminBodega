<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fruit extends Model
{
    protected $fillable = [
        'store_id','name','description'
    ];

    public function store()
    {
        return $this->belongsTo('App\Store');
    }
}
