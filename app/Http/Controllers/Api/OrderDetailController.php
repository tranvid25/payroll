<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    public function index(){
     $Order=OrderDetail::all();
     if($Order){
        return response()->json([
            'status'=>200,
            'content'=>$Order
        ]);
     }
     else{
        return response()->json([
            'status'=>404,
            'message'=>'not found Order'
        ]);
     }
    }
    public function show($id){
        $Order=OrderDetail::findOrFail($id);
        if($Order){
            return response()->json([
                'status'=>200,
                'message'=>$Order
            ]);
        }
        else{
            return response()->json([
                'status'=>404,
                'message'=>'not found Order'
            ]);
        }
    }
    public function store(Request $request){
        
    }

}
