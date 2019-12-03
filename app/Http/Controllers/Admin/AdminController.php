<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\Message;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('admin.index');
    }

    public function addMessage(Request $request){
        $message=$request->input('message','');
        $imagecheck=$request->input('imagecheck',array());
        $image='';

        foreach ($imagecheck as $value) {
            $image.=Str::after($value, asset('/manager/').'/').',';
        }

        $data['message']=$message;
        $data['image']=$image;
        $data['status']=1;
        $data['u_id']=Auth('')->id();
        $data['creation_time']=date('Y-m-d H:i:s');
        $data['update_time']=date('Y-m-d H:i:s');
        $messageModel=new Message();
        $messageModel->addMessage($data);
        return view('admin.index');
    }




}
