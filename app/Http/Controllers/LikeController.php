<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store(Request $request)
    {
        
        Auth::loginUsingId(2);
        $request->validate([
            'order_id'=>'required'
        
        ]);
       
        $user=$request->user();
        
        $like=Like::where('user_id',$user->id)->where('order_id',$request->order_id)->first();
        
        if($like){
            $like->delete();
            return response()->json([
                'message'=>'you unlike a order',
            ],200);
        
        }

        else
        {
            $like=new Like();
            $like->user_id =$user->id;
            $like->order_id=$request->order_id;
            if($like->save()){
               
                return response()->json([
                    'message'=>'you like a order',
                    'like'=>$like
                ],201);
            }

            else
            {
                return response()->json([
                    'message'=>'error try again'
                ],500);
            }
        }
    }
}
