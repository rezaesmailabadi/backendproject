<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Otp;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index(Order $order){
        
       
        /// براساس بیشترین بازدید
        $orderfavorites=Order::popularAllTime()->get();

        if (!$orderfavorites) {
            return response()->json([
                'message' => "not found"
            ], 404);
        }
       
        
     
        return response()->json([
            'orderfavorites' => $orderfavorites
        ], 200);
        

    }
}
