<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use mysql_xdevapi\Exception;

class ApiController extends Controller
{
    //上传图片接口
    public function updateImage(Request $request){
        try{
            $data['image']=asset($request->file('image')->store('manager','public'));
            $data['cade']=200;
        }catch (\Exception $e){
            $data['cade']=402;
            return $data;
        }
        return $data;
        
    }


}
