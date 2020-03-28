<?php

namespace App\Http\Controllers;

use App\Seller;
use Illuminate\Http\Request;

class SellerController extends Controller
{

    public function create(Request $request){
        $seller = Seller::create([
            'store_id' => $request->id,
            'name' => $request->name,
        ]);
        $storeId = $request->id;
        $sellers = Seller::whereHas('store', function ($store) use($storeId){
            $store->where('id', '=', $storeId);
        })->orderBy('id', 'desc')->get();
        return response()->json(['data' => true, 'sellers' => $sellers]);
    }

    public function update(Request $request){
        $seller = Seller::find($request->sellerId);
        $seller->name = $request->name;
        $seller->save();
        $storeId = $seller->store_id;
        $sellers = Seller::whereHas('store', function ($store) use($storeId){
            $store->where('id', '=', $storeId);
        })->orderBy('id', 'desc')->get();
        return response()->json(['data' => true, 'sellers' => $sellers]);
    }
}
