<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Faveriteorder;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderImage;
use Illuminate\Http\Request;


class OrderController extends Controller
{
    public function index(Order $order)
    {
        $orders = Order::where('publishable', 0)->get();
        // $orders = Order::all();
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

    public function getUser($token)
    {
        $user = User::where('token', $token)->first();
        if (!$user) {
            return abort(401);
        }
        return $user;
    }



    public function store(Request $request)
    {

        // return response()->json([
        //     'message' => "successfully",
        //     'data' => $request
        // ], 200);
        // try {
        $inputs = $request->all();
        $newOrder['user_id'] = $this->getUser($inputs['user_id'])->id;
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
        $newOrder['token'] = $inputs['token'];

        Order::create($newOrder);
        return response()->json([
            'message' => "successfully"
        ], 200);

        // dd($request);
    }




    public function update(request $request, $id)
    {


        try {
            $order = Order::where('id', $id)->get();

            $updatedOrder = $order[0];

            $updatedOrder['user_id'] = $this->getUser($request['user_id'])->id;
            $updatedOrder['title'] = $request['title'];
            $updatedOrder['image_one'] = $request['image_one'];
            $updatedOrder['image_two'] = $request['image_two'];
            $updatedOrder['image_three'] = $request['image_three'];
            $updatedOrder['introduction'] = $request['introduction'];
            $updatedOrder['nardeban'] = $request['nardeban'];
            $updatedOrder['urgent'] = $request['urgent'];
            $updatedOrder['min_price'] = $request['min_price'];
            $updatedOrder['max_price'] = $request['max_price'];
            $updatedOrder['category_id'] = $request['order_category'];
            $updatedOrder['delivery_date'] = $request['delivery_date'];
            $updatedOrder['token'] = $request['token'];
            $updatedOrder['publishable'] = 0;

            $updatedOrder->update();
            return response()->json([
                'message' => "successfully"
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'message' => "wrong",
                'data' => $order[0]['token']
            ], 500);
        }
    }


    public function destroy($id)
    {
        $order = Order::where('id', $id)->get();
        if (!$order) {
            return response()->json([
                'message' => "not found"
            ], 404);
        }
        $order->delete();
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




    public function Relatedproducts(request $request, $id)
    {
        // dd($request);
        $raltedproducts = Order::where('category_id', $id)->get();
        return response()->json([
            'results' => $raltedproducts
        ], 200);
    }


    public function faveriteorder(Request $request)
    {
        $inputs = $request->all();
        $newOrder['user_id'] = $this->getUser($inputs['user_id'])->id;
        $newOrder['order_id'] = $inputs['order_id'];
        Faveriteorder::create($newOrder);
        return response()->json([
            'results' => 'ok',
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