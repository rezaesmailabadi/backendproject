<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    public function search(Request $request, $query)
    {
        // dd($request);
        // $order_query=Order::with(['user','category']);
        // $order_query=Order::with(['category']);

        if ($query) {
            $order_query = Order::where('title', "LIKE", "%" . $query . "%")->orwhere('introduction', "LIKE", "%" . $query . "%")->get();
        }

        // if ($query->category) {
        //     $order_query->whereHas('category', function ($query) use ($request) {
        //         $query->where('category_id', $query->category);
        //     });
        // }
        // $order=$order_query->get();



        return response()->json([
            'message' => 'order successfully fetched',
            'data' => $order_query
        ], 200);
    }





    public function price(Request $request)
    {

        // $order_query=Order::with(['user','category']);
        // $order_query = Order::with(['category']);


        // $orders = $request->max_price && $request->min_price ? $order_query->whereBetween('price', [$request->min_price, $request->max_price]) :
        //     $order_query->when($request->min_price, function ($query) use ($request) {
        //         $query->where('price', '>=', $request->min_price)->get();
        //     })->when($request->max_price, function ($query) use ($request) {
        //         $query->where('price', '<=', $request->max_price)->get();
        //     })->when(!($request->min_price && $request->max_price), function ($query) {
        //         $query->get();
        //     });

        // $order = $order_query->get();

        $order = Order::where('min_price', $request->min_price)->get();

        return response()->json([
            'message' => 'order successfully fetched',
            'data' => $order
        ], 200);
    }
}
