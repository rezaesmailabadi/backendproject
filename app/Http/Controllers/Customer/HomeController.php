<?php

namespace App\Http\Controllers\Customer;


use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{


    public function latestorder()
    {
        // dd('hi');
        $LatestOrders = Order::latest()->take(50)->get();

        return response()->json([
            'results' => $LatestOrders
        ], 200);

        return view('custmoer.home', compact('mostVisitedOrders'));
        // return view('customer.home', compact('mostVisitedOrders');
    }



    

















}
