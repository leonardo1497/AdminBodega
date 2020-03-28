<?php

namespace App\Http\Controllers;

use App\Cellar;
use Illuminate\Http\Request;

class CellarController extends Controller
{
    public function create(Request $request){
        $kg = $request->ton * 1000;
        $cellar = Cellar::create([
            'store_id' => $request->storeId,
            'fruit_id' => $request->fruitId,
            'ton' => $request->ton,
            'price_ton' => $request->priceTon,
            'kg' => $kg,
            'first' => $request->first,
            'second' => $request->second
        ]);

        $storeId = $request->storeId;
        $cellars = Cellar::whereHas('store', function ($store) use($storeId){
            $store->where('id', '=', $storeId);
        })->orderBy('id', 'desc')->with('fruit')->get();
        return response()->json(['data' => true, 'cellars' => $cellars]);
    }

    public function update(Request $request){
        $cellar = Cellar::find($request->id);
        $cellar->first = $request->first;
        $cellar->second = $request->second;
        $cellar->active = $request->active;
        $cellar->save();

        $storeId = $cellar->store_id;
        $cellars = Cellar::whereHas('store', function ($store) use($storeId){
            $store->where('id', '=', $storeId);
        })->orderBy('id', 'desc')->with('fruit')->get();
        return response()->json(['data' => true, 'cellars' => $cellars]);
    }
}
