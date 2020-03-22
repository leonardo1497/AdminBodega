<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'name','address'
    ];

    public function fruits()
    {
        return $this->hasMany('App\Fruit');
    }

    public function customers()
    {
        return $this->hasMany('App\Customer');
    }

    public function sellers()
    {
        return $this->hasMany('App\Seller');
    }

    public function cellars()
    {
        return $this->hasMany('App\Cellar')->with('fruit');
    }

    public function daysales()
    {
        return $this->hasMany('App\DaySale')->orderBy('id', 'desc');
    }

}
