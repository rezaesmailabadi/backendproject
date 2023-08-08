<?php

namespace App\Http\Controllers;

use App\Http\Services\Image\ImageService;
use App\Models\Like;
use App\Models\Order;
use App\Models\Resume;
use App\Models\User;
use Facade\FlareClient\Stacktrace\File as StacktraceFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use File;
use Illuminate\Http\File as HttpFile;
use Illuminate\Support\Facades\File as FacadesFile;

class ProfileController extends Controller
{

    public function getUser($token)
    {
        $user = User::where('token', $token)->first();
        if (!$user) {
            return abort(401);
        }
        return $user;
    }

    public function myProfile($id)
    {
        // Auth::loginUsingId(1);
        // dd("hi");

        $user = $this->getUser($id);

        $first_name = $user->first_name;
        $last_name = $user->last_name;
        $email = $user->email;
        $mobile = $user->mobile;
        $national_code = $user->national_code;
        $profile_photo_path = $user->profile_photo_path;
        $password = $user->password;
        //count my_order
        $count_my_orders = Order::where('user_id', $user->id)->count();





        //count my_popular_order
        $like = Like::where('user_id', $user->id)->get('order_id');
        $count_my_popular_orders = order::find($like)->count();



        return response()->json([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'mobile' => $mobile,
            'national_code' => $national_code,
            'profile_photo_path' => $profile_photo_path,
            'count_my_orders' => $count_my_orders,
            'count_my_popular_orders' => $count_my_popular_orders,
            'password' => $password,


            // 'password' => $password


        ], 200);
    }




    public function change_password(request $request, $id)
    {

        // Auth::loginUsingId(2);
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|min:6|max:100',
            'confirm_password' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'validations fails',
                'errors' => $validator->errors()
            ], 422);
        }

        // $user = $request->user();
        $user = $this->getUser($id);

        if (Hash::check($request->old_password, $user->password)) {

            $user->update([
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'message' => 'password successfully update',
            ], 200);
        } else {
            return response()->json([
                'message' => 'old password dos not matched',

            ], 400);
        }
    }





    public function update_profile(Request $request, user $user, ImageService $imageService, $id)
    {


        $inputs = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'national_code' => $request->national_code,
            'profile_photo_path' => $request->profile_photo_path,
            'email' => $request->email,
            'mobile' => $request->mobile
        ];


        // Auth::loginUsingId(2);
        // $user = Auth()->user();
        $user = $this->getUser($id);


        if ($request->hasFile('profile_photo_path')) {


            if ($user->profile_photo_path) {
                $old_path = public_path() . '/images/profile_photo_path/' . $user->profile_photo_path;

                if (FacadesFile::exists($old_path)) {

                    FacadesFile::delete($old_path);
                }
            }
            $image_name = 'profile-image-' . time() . '.' . $request->profile_photo_path->extension();
            $request->profile_photo_path->move(public_path('/images/profile_photo_path/'), $image_name);
        } else {
            $image_name = $user->profile_photo_path;
        }


        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'national_code' => $request->national_code,
            'profile_photo_path' => $request->profile_photo_path,
            'email' => $request->email,
            'mobile' => $request->mobile,
        ]);
        return response()->json([
            'message' => "successfully"
        ], 200);
    }




    public function my_order(Order $order, $id)
    {

        $user = $this->getUser($id);
        $orders = Order::where('user_id', $user->id)->where('publishable', 1)->get();
        if (!$orders) {
            return response()->json([
                'message' => "not found"
            ], 404);
        }
        return response()->json([
            'results' => $orders
        ], 200);
    }

    public function my_popular_order($id, Like $like)
    {
        $user = $this->getUser($id);
        $like = Like::where('user_id', $user->id)->get('order_id');
        // dd($like);
        $my_popular_order = order::find($like);


        if (!$my_popular_order) {
            return response()->json([
                'message' => "not found"
            ], 404);
        }



        return response()->json([
            'my_popular_order' => $my_popular_order,
        ], 200);
    }



    public function Awaiting_confirmation($id)
    {
        $user = $this->getUser($id);
        $order = Order::where('user_id', $user->id)->where('publishable', 0)->get();
        if (!$order) {
            return response()->json([
                'message' => "not found"
            ], 404);
        }
        return response()->json([
            'my_await_order' => $order,
        ], 200);
    }



    public function resume(request $request,$id)
    {
      
        // $user = $this->getUser($id);
   
        $request->validate([
            'username'=>'required',
        ]);
        $profile_photo_path=$request->file('profile_photo_path')->store('profile_photo','public');
        $work_samples=$request->file('work_samples')->store('work_samples','public');
        $resume=Resume::create([
        'username'=>$request->username,
        'country'=>$request->country,
        'city'=>$request->city,
        'proficiency'=>$request->proficiency,
        'work_samples'=>$work_samples,
        'educational_records'=>$request->educational_records,
        'achievement'=>$request->achievement,
        'profile_photo_path'=>$profile_photo_path,
        'other_information'=>$request->other_information,
        'work_resume'=>$request->work_resume,
        'title'=>$request->title,
        'role'=>$request->role,
        'Holidays'=>$request->Holidays,
        'user_id'=>$id
        // 'user_id'=>$user->id
        ]);
        


        return response()->json([
         'message'=>'resume uolode',
         'statuse'=>'success',
         'resume'=>$resume

        ], 200); 
    }


    public function my_resume($id)
    {
       $user=user::where('id',$id)->first();
        // $user = $this->getUser($id);

        $first_name = $user->first_name;
        $last_name = $user->last_name;
        $profile_photo_path = $user->profile_photo_path;


        $resume=Resume::where('user_id',$id)->first();
        return response()->json([
            'message'=>' show resume  ',
            'statuse'=>'success',
            'resume'=>$resume,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'profile_photo_path' => $profile_photo_path,
   
           ], 200); 
       
    }

}
