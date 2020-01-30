<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use mysql_xdevapi\Exception;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    //上传图片接口
    public function updateImage(Request $request){
        try{
            $data['image']=asset($request->file('image')->store('manager','public'));
            $data['code']=200;
        }catch (\Exception $e){
            $data['code']=402;
            return $data;
        }
        return $data;

    }

    //上传图片接口
    public function test(Request $request){

        $a=$request->input('a','0');
        $b=$request->input('b','0');
        $data['a']=$a;
        $data['b']=$b;

        DB::table('w_test')->insert($data);
        return 1;

    }


}
