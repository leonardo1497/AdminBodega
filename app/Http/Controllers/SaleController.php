<?php

namespace App\Http\Controllers;

use App\Cellar;
use App\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function create(Request $request){
        $message = "";
        $items = json_decode($request->items, true);
        $blnValid = true;
        foreach ($items as $item) {
            $cellar = Cellar::find($item['idCellar']);
            $kgCellar = $cellar->kg;
            if($kgCellar < 0){
                $blnValid = false;
                break;
            }
        }
        if($blnValid){
            $pay = 0;
            if($request->pay == 1){
                $pay = $request->total;
            }else{
                $pay = $request->creditPay;
            }
            Sale::create([
                'customer_id' => $request->customer,
                'seller_id' => $request->seller,
                'seller_delivery_id' => $request->delivery,
                'day_sale_id' => $request->id,
                'type_pay' => $request->pay,
                'fruits' => $request->items,
                'pays' => $request->credit,
                'total' => $request->total,
                'pay' => $pay,
            ]);
            foreach ($items as $item) {
                $cellar = Cellar::find($item['idCellar']);
                $kgCellar = $cellar->kg;
                $cellar->kg = $kgCellar - $item['Cantidad/kg'];
                $cellar->save();
            }
        }else{
            $message = "Stock insuficiente de alguna de las frutas en bodega";
        }
        return response()->json(['data' => $blnValid, "message" => $message]);
    }

    public function updatePayment(Request $request){

        $sale = Sale::find($request->id);
        $sale->pays = $request->pays;
        $sale->pay = $sale->pay + $request->payment;
        $sale->save();
        $daySaleId = $sale->day_sale_id;
        $sales = Sale::whereHas('daySale', function ($daySale) use($daySaleId){
            $daySale->where('id', '=', $daySaleId);
        })->orderBy('id', 'desc')->with('customer')->get();
        return response()->json(["data" => true, "sales" => $sales]);
    }
}
