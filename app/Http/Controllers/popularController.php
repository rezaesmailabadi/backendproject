<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Order;
use Illuminate\Http\Request;

class popularController extends Controller
{
public function index(Order $order,Like $like)
{
    
    $like=Order::withCount('likes')->orderBy('likes_count', 'desc')->take(5)->get();


    if (!$like) {
        return response()->json([
            'message' => "not found"
        ], 404);
    }
   
    
 
    return response()->json([
        'popularorder' => $like,
    ], 200);
    

}
   
}

