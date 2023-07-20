<?php

namespace App\Http\Controllers;

use App\Http\Services\Image\ImageService;
use App\Models\Order;
use App\Models\Order_Image;
use App\Models\OrderImage;
use Illuminate\Http\Request;

class GalleryController extends Controller
{









    public function index()
    {

       
//
    }




    public function store(Request $request, Order $order, ImageService $imageService)
    {

        $inputs = $request->all();
        
        if ($request->hasFile('image')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'order-image');
            $result = $imageService->save($request->file('image'));

            if ($result === false) {
          dd('ooooo');
            }
            $inputs['image'] = $result;
        }
        $images = OrderImage::create($inputs);

        dd('hi');


        // try {
        //     $validated = $request->validate([
        //         'image' => 'required
        //     ',
        //     ]);

        //     $inputs = $request->all();

        //     if ($request->hasFile('image')) {

        //         $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'order-image');
        //         $result = $imageService->save($request->file('image'));

        //         if ($result === false) {

        //             return response()->json([
        //                 'message' => "not found"
        //             ], 500);
        //         }
        //         $inputs['image'] = $result;
        //         $inputs['order_id'] = $order->id;
        //         $gallery = Order_Image::create($inputs);

        //         return response()->json([
        //             'message' => "successfully"
        //         ], 200);
        //     }
        // } catch (\Exception $e) {


        //     return response()->json([
        //         'message' => "wrong"
        //     ], 500);
        // }
    }
   
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        //
    }

   
    public function destroy($id)
    {
        // $order_images = Order_Image::find($id);

        // if (!$order_images) {
        //     return response()->json([
        //         'message' => "not found"
        //     ], 404);
        // }
        // $order_images->delete();

        // return response()->json([
        //     'message' => "sussessfully"
        // ], 200);
        
       
    }
}
