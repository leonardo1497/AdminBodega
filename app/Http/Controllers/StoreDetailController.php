<?php

namespace App\Http\Controllers;

use App\Cellar;
use App\Fruit;
use App\Sale;
use Illuminate\Http\Request;
use App\Store;

class StoreDetailController extends Controller
{
    public function index(Request $request)
    {
        $store = Store::find($request->id);
        
        return view('storeDetail',['store' => $store]);
    }

    public function editFruit(Request $request){
        $fruit = Fruit::find($request->id);
        return response()->json(['fruit' => $fruit]);
    }

    public function editCellar(Request $request){
        $cellar = Cellar::find($request->id);
        return response()->json(['cellar' => $cellar]);
    }

    public function getSales(Request $request){
        $daySaleId = $request->id;
        $sales = Sale::whereHas('daySale', function ($daySale) use($daySaleId){
            $daySale->where('id', '=', $daySaleId);
        })->orderBy('id', 'desc')->with('customer')->get();
        return response()->json(['sales' => $sales]);
    }

    public function editSale(Request $request){
        $sale = Sale::find($request->id);

        return response()->json(['sale' => $sale]);
    }
}
