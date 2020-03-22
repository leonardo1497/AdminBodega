<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Store;

class StoresMenuController extends Controller
{
    public function index()
    {
        $stores = Store::All();
        return view('mainStore',['stores' => $stores]);
    }
}
