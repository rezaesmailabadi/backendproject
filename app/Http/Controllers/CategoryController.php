<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceResponse;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return response()->json([
            'results' => $categories
        ], 200);
    }



    public function show($id)
    {
        $categories = Category::find($id);
        if (!$categories) {
            return response()->json([
                'message' => "not found"
            ], 404);
        }



        return response()->json([
            'Categories' => $categories
        ], 200);
    }



    public function store(CategoryRequest $request)
    {

        try {


            Category::create([


                'name' => $request->name,
                'description' => $request->description,
                'image' => $request->image,
                'status' => $request->status,
                'tags' => $request->tags


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


    public function update(CategoryRequest $request, $id)
    {


        try {

            $categories = Category::find($id);

            if (!$categories) {
                return $categories()->json([
                    'message' => "not found"
                ], 404);
            }



            $categories->name = $request->name;
            $categories->description = $request->description;
            $categories->image = $request->image;
            $categories->status = $request->status;
            $categories->tags = $request->tags;

            $categories->save();



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


        $categories = Category::find($id);

        if (!$categories) {
            return response()->json([
                'message' => "not found"
            ], 404);
        }
        $categories->delete();

        return response()->json([
            'message' => "sussessfully"
        ], 200);
    }


    public function ordercategory($id)
    {
        // User Detail 
        $orders = Order::where('category_id', $id)->get();

        // Return Json Response
        return response()->json([
            'results' => $orders
        ], 200);
    }
}
