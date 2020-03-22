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

        return response()->json(['data' => true]);
    }
}
