<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\Message;
use App\Models\Video;

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
        return view('admin.index',['xd'=>11]);
    }

    /*
     * 添加朋友圈
     */
    public function addMessage(Request $request){
        $message=$request->input('message','');
        $user=$request->input('user','');
        $imagecheck=$request->input('imagecheck',array());
        $image='';
        //dd($imagecheck);
        foreach ($imagecheck as $value) {
            $image.=Str::after($value, asset('/')).',';
        }
        $data['message']=$message;
        $data['image']=substr($image, 0, -1);
        $data['status']=2;
        $data['u_id']=Auth('')->id();
        $data['creation_time']=date('Y-m-d H:i:s');
        $data['update_time']=date('Y-m-d H:i:s');
        $messageModel=new Message();
        $messageModel->addMessage($data);
        if($user){
            $user_data['code']=200;
            return $user_data;
        }

        return view('admin.index',['xd'=>11]);
    }

    public function video(){
        return view('admin.video',['xd'=>21]);
    }

    public function addVideo(Request $request){
        $data['url']=$request->file('mp4')->store('video','public');
        $data['name']=$request->input('name');
        $data['message']=$request->input('message');
        $data['add_time']=date('Y-m-d H:i:s');
        $data['status']=1;
        $videoModel=new Video();
        $add_info=$videoModel->addVideo($data);
        return view('admin.video',['xd'=>21]);
    }

    public function videoList(){
        $videoModel=new Video();
        $data=$videoModel->getVideo();
        return view('admin.tableList',['xd'=>22,'data'=>$data]);
    }

    public function videoDel(Request $request){
        $id=$request->input('id');
        $videoModel=new Video();
        $videoModel->delVideo($id);
        return redirect('/admin/videoList');
    }

    public function bvideo(Request $request){
        $id=$request->input('id');
        return view('admin.bvideo',['xd'=>22,'id'=>$id]);
    }

    public function getVideoUrl(Request $request){
        try{
            $id=$request->id;
            if($_SERVER['HTTP_REFERER']!=url('admin/bvideo').'?id='.$id){
                $data['code']=403;
                return $data;
            }
            $videoModel=new Video();
            $data=$videoModel->oneVideo($id);
            return redirect(asset($data->url));
        }catch (\Exception $e){
            $data['code']=402;
            return $data;
        }
    }

    public function test(Request $request){
        $a=$_SERVER['HTTP_REFERER'];
        dd($a);
    }




}
