<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    public function index(){
        $province=Province::all();
        if($province){
            return response()->json([
                'status'=>200,
                'content'=>$province
            ]);
        }
        else{
            return response()->json([
                'status'=>404,
                'message'=>'not found province'
            ]);
        }
    }
}
