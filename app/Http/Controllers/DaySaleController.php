<?php

namespace App\Http\Controllers;

use App\DaySale;
use Illuminate\Http\Request;

class DaySaleController extends Controller
{
    public function create(Request $request){
        $message = "";
        $daySales ="";
        $daySale = DaySale::orderBy('created_at', 'desc')->first();
        $dateSale = $daySale->created_at->format('m/d/Y');
        $now = new \DateTime();
        $todayDate = $now->format('m/d/Y');
        if($dateSale != $todayDate){
            $fruit = DaySale::create([
                'store_id' => $request->id,
            ]);
            $storeId = $request->id;
            $daySales = DaySale::whereHas('store', function ($store) use($storeId){
                $store->where('id', '=', $storeId);
            })->orderBy('id', 'desc')->get();
            $result = true;
        }else{
            $result = false;
            $message = "Ya se ha iniciado la venta del día";
        }
        
        return response()->json(['data' => $result,'daySales' => $daySales, "message" => $message]);
    }
}
