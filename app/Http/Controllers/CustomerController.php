<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function create(Request $request){

        $customer = Customer::create([
            'store_id' => $request->id,
            'name' => $request->name,
            'description' => $request->description,
        ]);
        $storeId = $request->id;
        $customers = Customer::whereHas('store', function ($store) use($storeId){
            $store->where('id', '=', $storeId);
        })->orderBy('id', 'desc')->get();

        return response()->json(['data' => true, 'customers' =>$customers]);
    }

    public function update(Request $request){

        $customer = Customer::find($request->customerId);
        $customer->name = $request->name;
        $customer->description = $request->description;
        $customer->save();
        $storeId = $customer->store_id;
        $customers = Customer::whereHas('store', function ($store) use($storeId){
            $store->where('id', '=', $storeId);
        })->orderBy('id', 'desc')->get();
        return response()->json(['data' => true, 'customers' =>$customers]);
    }
}
