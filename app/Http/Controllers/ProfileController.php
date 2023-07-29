<?php

namespace App\Http\Controllers;

use App\Http\Services\Image\ImageService;
use App\Models\Like;
use App\Models\Order;
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
    public function myProfile($id)
    {
        // Auth::loginUsingId(1);
        // dd("hi");

        $user = User::where('id', $id)->first();

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
            'firstname' => $first_name,
            'lastname' => $last_name,
            'email' => $email,
            'mobile' => $mobile,
            'nationalcode' => $national_code,
            'profilephoto' => $profile_photo_path,
            'count_my_orders' => $count_my_orders,
            'count_my_popular_orders' => $count_my_popular_orders,


            // 'password' => $password


        ], 200);
    }




    public function change_password(request $request)
    {

        Auth::loginUsingId(2);
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

        $user = $request->user();

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





    public function update_profile(Request $request, user $user, ImageService $imageService)
    {


        $inputs = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'national_code' => $request->national_code,
            'profile_photo_path' => $request->profile_photo_path
        ];


        Auth::loginUsingId(2);
        $user = Auth()->user();


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
            'firs_name' => $request->first_name,
            'last_name' => $request->last_name,
            'national_code' => $request->national_code,
            'profile_photo_path' => $image_name,
        ]);
        return response()->json([
            'message' => "successfully"
        ], 200);
    }




    public function my_order(Order $order, $id)
    {


        $orders = Order::where('user_id', $id)->get();
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
        $like = Like::where('user_id', $id)->get('order_id');
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
}
