<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fruit;
use App\Events\FruitTable;

class FruitController extends Controller
{
    public function create(Request $request){
        $fruit = Fruit::create([
            'store_id' => $request->id,
            'name' => $request->name,
            'description' => $request->description,
        ]);
        $storeId = $request->id;
        $fruits = Fruit::whereHas('store', function ($store) use($storeId){
            $store->where('id', '=', $storeId);
        })->orderBy('id', 'desc')->get();
        
        return response()->json(['data' => true,'fruits' => $fruits ]);
    }

    public function update(Request $request){
        $fruit = Fruit::find($request->fruitId);
        $fruit->name = $request->name;
        $fruit->description = $request->description;
        $fruit->save();
        $storeId = $fruit->store_id;
        $fruits = Fruit::whereHas('store', function ($store) use($storeId){
            $store->where('id', '=', $storeId);
        })->orderBy('id', 'desc')->get();
        return response()->json(['data' => true,'fruits' => $fruits ]);
    }
}
