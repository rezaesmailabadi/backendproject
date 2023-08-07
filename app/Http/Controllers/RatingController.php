<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function add(Request $request)
    {



        $stars_rated = $request->order_rating;
        $order_id = $request->order_id;
        $user_id = $request->user_id;

        // $order_user_id = order::where('id', $order_id)->get('user_id');
        
        
        $order_check = Order::where('id', $order_id)->where('publishable', 1)->first();



        if ($order_check) {


            $existing_rating = Rating::where('user_id', $user_id)->where('order_id', $order_id)->first();

            if ($existing_rating) {
                $existing_rating->stars_rated = $stars_rated;

                $existing_rating->update();
                return response()->json([
                    'results' => 'update'
                ], 200);
            } else {
                $rate =  Rating::create([
                    'user_id' => $user_id,
                    'order_id' => $order_id,
                    'stars_rated' => $stars_rated,
                    'order_user_id'=>$order_check->user_id,
                ]);

                return response()->json([
                    'results' => $rate
                ], 200);
            }
        } else {

            return response()->json([
                'results' => 'you cannot rating order'
            ], 500);
        }
    }

    public function showrating($user_id){
       
        $rating=Rating::where('order_user_id',$user_id)->get();
        
        $count_rating=$rating->count();
        if($count_rating){
        $rating_sum=Rating::where('order_user_id',$user_id)->sum('stars_rated');
        $rating_value=$rating_sum/$count_rating;
     
        return response()->json([
            'results' => $rating_value
        ], 200);
    }
    else{
        $rating_value=0;
        return response()->json([
            'results' => $rating_value
        ], 200);

    }

    }
}
