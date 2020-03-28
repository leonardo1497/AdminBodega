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
        return $this->hasMany('App\Fruit')->orderBy('id', 'desc');
    }

    public function customers()
    {
        return $this->hasMany('App\Customer')->orderBy('id', 'desc');
    }

    public function sellers()
    {
        return $this->hasMany('App\Seller')->orderBy('id', 'desc');
    }

    public function cellars()
    {
        return $this->hasMany('App\Cellar')->with('fruit')->orderBy('id', 'desc');
    }

    public function daysales()
    {
        return $this->hasMany('App\DaySale')->orderBy('id', 'desc');
    }

}
