<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    public function search(Request $request)
    {
        $order_query=Order::with(['user','category']);
        if($request->keyword)
        {
            $order_query->where('title',"LIKE","%".$request->keyword."%");
        }

        if($request->category){
            $order_query->whereHas('category',function($query)use($request){
                $query->where('slug',$request->category);
            });
        }
        if($request->user_id){
            $order_query->where('user_id',$request->user_id);
        }

        if($request->sortBy && in_array($request->sortBy,['id','creates_at'])){
            $sortBy=$request->sortBy;
        }
        else{
            $sortBy='id';
        }
        if($request->sortOrder && in_array($request->sortOrder,['asc','desc'])){
            $sortOrder=$request->sortOrder;
        }
        else{
            $sortOrder='desc';
        }
        if($request->perPage){
            $perPage=$request->perPage;
        }
        else{
            $perPage=5;
        }

        if($request->paginate){
            $order=$order_query->orderBy($sortBy,$sortOrder)->paginate($perPage);

        }
        else{
            $order=$order_query->orderBy($sortBy,$sortOrder)->get();
        }
        
        return response()->json([
            'message'=>'order successfully fetched',
            'data'=>$order
        ],200);

    }



    

        
    }



