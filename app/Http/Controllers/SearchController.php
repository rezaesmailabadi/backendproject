<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    public function search(Request $request)
    {





        $text_search = $request->get('text_search');
        $category_id = $request->get('category_id');



        // return response()->json([
        //     'message' => 'order successfully fetched',
        //     'data' => $category_id
        // ], 200);



        if ($request->filled('text_search') && $request->filled('category_id')) {
            $orders = Order::where('title', "LIKE", "%" . $text_search . "%")->orwhere('introduction', "LIKE", "%" . $text_search  . "%")->where('category_id', $category_id)->get();
            return response()->json([
                'message' => 'order ',
                'data' => $orders
            ], 200);
        } else {
            if ($request->text_search) {
                $orders = Order::where('title', "LIKE", "%" . $text_search . "%")->orwhere('introduction', "LIKE", "%" . $text_search  . "%")->get();
                return response()->json([
                    'message' => 'order minprice',
                    'data' => $orders
                ], 200);
            } else if ($request->category_id) {
                $orders = Order::where('category_id', $category_id)->get();
                return response()->json([
                    'message' => 'order maxprice',
                    'data' => $orders
                    // این ینی سقفش اینقدر باشه 
                ], 200);
            } else {
                $orders = Order::all();
                return response()->json([
                    'message' => 'order all',
                    'data' => $orders
                ], 200);
            }
        }

        // $order_query=Order::with(['user','category']);
        // $order_query = Order::with(['category']);

        // if ($request->keyword) {
        //     $order_query->where('title', "LIKE", "%" . $request->keyword . "%")
        //         ->orwhere('introduction', "LIKE", "%" . $request->keyword . "%");
        // }

        // if ($request->category) {
        //     $order_query->whereHas('category', function ($query) use ($request) {
        //         $query->where('slug', $request->category);
        //     });
        // }
        // $order = $order_query->get();



        // return response()->json([
        //     'message' => 'order successfully fetched',
        //     'data' => $order
        // ], 200);
    }





    public function price(Request $request)
    {

        /*
        $orders = $request->max_price && $request->min_price ? Order::whereBetween('price', [$request->min_price, $request->max_price]) :
            $order_query->when($request->min_price, function ($query) use ($request) {
                Order::where('price', '>=', $request->min_price)->get();
            })->when($request->max_price, function ($query) use ($request) {
                Order::where('price', '<=', $request->max_price)->get();
            })->when(!($request->min_price && $request->max_price), function ($query) {
                $query->get();
            });
*/


        // dd($request->min_price);


        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');




        if ($request->filled('min_price') && $request->filled('max_price')) {
            $orders = Order::where('min_price', '>=', $minPrice)->where('max_price', '<=', $maxPrice)->get();
            return response()->json([
                'message' => 'order wherebetween',
                'data' => $orders
            ], 200);
        } else {
            if ($request->min_price) {
                $orders = Order::where('min_price', '>=', $minPrice)->get();
                return response()->json([
                    'message' => 'order minprice',
                    'data' => $orders
                    // این ینی کفش اینقدر باشه 
                ], 200);
            } else if ($request->max_price) {
                $orders = Order::where('max_price', '<=', $maxPrice)->get();
                return response()->json([
                    'message' => 'order maxprice',
                    'data' => $orders
                    // این ینی سقفش اینقدر باشه 
                ], 200);
            } else {
                $orders = Order::all();
                return response()->json([
                    'message' => 'order all',
                    'data' => $orders
                ], 200);
            }
        }




        // if ($request->filled('min_price') && $request->filled('max_price')) {
        //     $orders = Order::whereBetween($minPrice, $maxPrice)->get();
        // return response()->json([
        //     'message' => 'order wherebetween',
        // ], 200);
        // } 

        // else {
        //     if ($request->min_price) {
        //         $orders = Order::where('min_price', '>=', $minPrice)->get();
        //         return response()->json([
        //             'message' => 'order minprice',
        //         ], 200);
        //     } else if ($request->max_price) {
        //         $orders = Order::where('max_price', '<=', $maxPrice)->get();
        //         return response()->json([
        //             'message' => 'order maxprice',
        //         ], 200);
        //     } else {
        //         $orders = Order::all();
        //         return response()->json([
        //             'message' => 'order all',
        //             'data' => $orders
        //         ], 200);
        //     }
        // }



        // $order = $order_query->get();

        // return response()->json([
        //     'message' => 'order successfully fetched',
        //     'data' => $orders
        // ], 200);
    }
}
