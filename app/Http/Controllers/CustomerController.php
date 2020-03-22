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

        return response()->json(['data' => true]);
    }
}
