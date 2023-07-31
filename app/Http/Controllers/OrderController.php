<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\OrderImage;
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
        $count = $orders->like()->count();
        dd($count);

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



    public function store(Request $request)
    {

        try {
            $inputs = $request->all();
            $newOrder['user_id'] = $inputs['user_id'];
            $newOrder['title'] = $inputs['title'];
            $newOrder['image_one'] = $inputs['image1'];
            $newOrder['image_two'] = $inputs['image2'];
            $newOrder['image_three'] = $inputs['image3'];
            $newOrder['introduction'] = $inputs['introduction'];
            $newOrder['nardeban'] = $inputs['nardeban'];
            $newOrder['urgent'] = $inputs['urgent'];
            $newOrder['min_price'] = $inputs['min_price'];
            $newOrder['max_price'] = $inputs['max_price'];
            $newOrder['category_id'] = $inputs['order_category'];
            $newOrder['delivery_date'] = $inputs['delivery_date'];
            Order::create($newOrder);
            return response()->json([
                'message' => "successfully"
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'message' => "wrong"
            ], 500);
        }
        // dd($request);
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



    public function newsorder()
    {
        $neworders = Order::latest()->get();
        return response()->json([
            'results' => $neworders
        ], 200);
    }




    public function datail($id)
    {
        $orders = Order::find($id);
        // $ordreimage = OrderImage::where('order_id', $id)->get();
        return response()->json([
            'results' => $orders
        ], 200);
    }




    public function Relatedproducts(request $request)
    {

        $raltedproducts = Order::where('category_id', $request->category_id)->get();
        return response()->json([
            'results' => $raltedproducts
        ], 200);
    }
}


      // foreach ($request->file('images') as $imagefile) {
            //     $image = new OrderImage();
            //     $path = $imagefile->store('/images/resource', ['disk' =>   'my_files']);
            //     $image->url = $path;
            //     $order = new Order;
            //     $image->order_id = $order->id;
            //     $image->save();
            // }