<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Str;

class UserController extends Controller
{
    //

    public function edit(Request $request){
        return view('admin.editUser');
    }

    public function editUser(Request $request){
        $validator = Validator::make($request->all(), [
            'valueName' => 'required',
            'value' => 'required',

        ]);
        //判断参数不为空
        if ($validator->fails()) {
            $data['code']=402;
            $data['message']='参数错误';
            return $data;
        }
        if($request->input('valueName')==="image"){
            $data[$request->input('valueName')]=Str::after($request->input('value'),asset('manager/'));
        }elseif($request->input('valueName')==="password"){


        }else{
            $data[$request->input('valueName')]=$request->input('value');
        }


        $id=Auth::id();
        $userModers=new User();
        $info=$userModers->edit($data,$id);
        if($info){
            $data['code']=200;
            $data['message']='修改成功';
            return $data;
        }else{
            $data['code']=402;
            $data['message']='修改修改失败';
            return $data;
        }


    }
}
