<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;


class OrderController extends Controller
{
    public function index(Order $order)
    {
        $orders = Order::all();
        return response()->json([
            'results' => $orders
        ], 200);
    }



    public function show($id)
    {

        $orders =  Order::find($id);

        if (!$orders) {
            return response()->json([
                'message' => "not found"
            ], 404);
        }

        //پکیج جهت ثبت بازدید هر سفارش
        ///https://github.com/coderflexx/laravisit
        $orders->visit()->withIp();




        return response()->json([
            'tickets' => $orders
        ], 200);
    }



    public function store(OrderRequest $request)
    {


        try {
            $realTimestampStart = substr($request->published_at, 0, 10);
            $inputs['published_at'] = date("Y-m-d H:i:s", (int)$realTimestampStart);


            Order::create([


                'user_id' => $request->user_id,
                'title' => $request->title,
                'introduction' => $request->introduction,
                'image' => $request->image,
                'status' => $request->status,
                'tags' => $request->tags,
                'price' => $request->price,
                'publishable' => $request->publishable,
                'category_id' => $request->category_id,

                'email' => $request->email,
                'mobile' => $request->mobile,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,


                // 'published_at' => $request->published_at,

            ]);


            return response()->json([
                'message' => "successfully"
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'message' => "wrong"
            ], 500);
        }
    }


    public function update(OrderRequest $request, $id)
    {


        try {

            $orders =  Order::find($id);
            // dd($tickets);

            if (!$orders) {
                return $orders()->json([
                    'message' => "not found"
                ], 404);
            }

            $realTimestampStart = substr($request->published_at, 0, 10);

            $inputs['published_at'] = date("Y-m-d H:i:s", (int)$realTimestampStart);


            $orders->title = $request->title;
            $orders->introduction = $request->introduction;
            $orders->image = $request->image;
            $orders->status = $request->status;
            $orders->tags = $request->tags;
            $orders->price = $request->price;
            $orders->publishable = $request->publishable;
            $orders->category_id = $request->category_id;
            $orders->email = $request->email;
            $orders->mobile = $request->mobile;
            $orders->first_name = $request->first_name;
            $orders->last_name = $request->last_name;



            // dd($tickets);
            $orders->save();




            return response()->json([
                'message' => "successfully"
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'message' => "wrong"
            ], 500);
        }
    }


    public function destroy($id)
    {


        $orders = Order::find($id);

        if (!$orders) {
            return response()->json([
                'message' => "not found"
            ], 404);
        }
        $orders->delete();

        return response()->json([
            'message' => "sussessfully"
        ], 200);
    }


    public function my_order()
    {

        $orders = Order::all();

        $count_order = Order::count();

        // dd($count_order);

        foreach ($orders as $order) {
            // dd($order);
            $order->title;
        }
        if (!$orders) {
            return response()->json([
                'message' => "not found"
            ], 404);
        }


        return response()->json([
            'message' => "sussessfully"
        ], 200);
    }
}
