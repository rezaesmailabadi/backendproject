<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    public function search(Request $request)
    {
        // $order_query=Order::with(['user','category']);
        $order_query = Order::with(['category']);

        if ($request->keyword) {
            $order_query->where('title', "LIKE", "%" . $request->keyword . "%")
                ->orwhere('introduction', "LIKE", "%" . $request->keyword . "%");
        }

        if ($request->category) {
            $order_query->whereHas('category', function ($query) use ($request) {
                $query->where('slug', $request->category);
            });
        }
        $order = $order_query->get();



        return response()->json([
            'message' => 'order successfully fetched',
            'data' => $order
        ], 200);
    }





    public function price(Request $request)
    {

        $order_query = Order::all();

        $orders = $request->max_price && $request->min_price ? $order_query->whereBetween('price', [$request->min_price, $request->max_price]) :
            $order_query->when($request->min_price, function ($query) use ($request) {
                $query->where('price', '>=', $request->min_price)->get();
            })->when($request->max_price, function ($query) use ($request) {
                $query->where('price', '<=', $request->max_price)->get();
            })->when(!($request->min_price && $request->max_price), function ($query) {
                $query->get();
            });

        $order = $order_query->get();

        return response()->json([
            'message' => 'order successfully fetched',
            'data' => $order
        ], 200);
    }
}
