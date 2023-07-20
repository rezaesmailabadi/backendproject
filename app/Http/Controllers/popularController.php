<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Order;
use Illuminate\Http\Request;

class popularController extends Controller
{
public function index(Order $order,Like $like)
{
    
    $like=like::where('order_id','1')->count();
    dd($like);
}
}
