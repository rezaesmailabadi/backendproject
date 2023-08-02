<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Suggest;
use App\Models\User;
use App\Notifications\SendEmailNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class SuggestController extends Controller
{
 public function suggest( request $request )
    {
       
        try {
            $inputs = $request->all();
            $newOrder['user_id'] = $inputs['user_id'];
            $newOrder['order_id'] = $inputs['order_id'];
            
            $newOrder['introduction'] = $inputs['introduction'];
            $newOrder['first_suggest'] = $inputs['first_suggest'];
           
            $newOrder['suggest_price'] = $inputs['suggest_price'];
          
            $newOrder['suggest_date'] = $inputs['suggest_date'];
           
          Suggest::create($newOrder);
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


    public function my_order_suggest($order_id)
    {
       
    $suggests=suggest::where('order_id',$order_id)->get();



   
    return response()->json([
        'message' => "successfully",
        'suggests'=> $suggests
    ], 200);
    
    }


    public function sendemail(request $request,$id)
     {
     
        $data=Order::find($id);
        $tomail=User::where('id',$data->user_id)->get();
        // dd($tomail);

      
        $details=[
     'greeting' => $request->greeting,
      'body'=>$request->body,
      'actiontext'=>$request->actiontext,
      'actionurl'=>$request->actionurl,
      'endpart'=>$request->endpart



        ];
        Notification::send($tomail,new SendEmailNotification($details));
       


        return response()->json([
        'message' => "successfully",
        'email'=> $details
    ], 200);
     }

public function markasread($id)
{
    if($id){
      $user=user::find($id);
      $unread=$user->unreadNotifications;
      
    
      return response()->json([
        'message' => "successfully",
        'notifications'=> $unread
    ], 200);
    }
}

    }
