<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Store;
use App\Events\StoreTable;

class StoreController extends Controller
{

    public function index()
    {
        $stores = Store::orderBy('id','desc')->get();
        return view('store',['stores' => $stores]);
    }

    public function create(Request $request){
        $store = Store::create([
            'store_id' => $request->id,
            'name' => $request->name,
            'address' => $request->address,
        ]);
        $stores = Store::orderBy('id','desc')->get();
        return response()->json(['data' => true, 'stores'=>$stores]);
    }

    public function edit(Request $request){

        $store = Store::find($request->id);
        return response()->json(['store' => $store]);
    }
    public function update(Request $request){

        $store = Store::find($request->id);
        $store->name = $request->name;
        $store->address = $request->address;
        $store->save();
        $stores = Store::orderBy('id','desc')->get();
        return response()->json(['data' => true, 'stores'=>$stores]);
    }
}
