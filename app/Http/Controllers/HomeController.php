<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Array_;
use App\Models\Comment;
use App\Models\Like;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $time=$request->input('getTime',date("Y-m-d H:i:s"));
        $page=$request->input('page',1);
        if($page===1){
            $time=date("Y-m-d H:i:s");
        }
        //发送的消息获取
        $messageModel=new Message();
        //查询的朋友圈
        $message=$messageModel->getMessage($time);
        //获取朋友圈id
        $m_ids=array();
        foreach ($message as $item) {
            $m_ids[]=$item->id;
            $item->u_image='manager/'.$item->u_image;
            $item->image=explode(',',$item->image);
        }
        //如果朋友圈的ID不为空
        if(!empty($m_ids)){
            $commentModel=new Comment();
            //查询所有的评论
            $comment=$commentModel->getComment($m_ids);
        }
        //将所有的评论根据mid分类
        $comments=array();
        if(!empty($comment)){
            foreach ($comment as $value){
                $comments[$value->m_id][]=$value;
            }
        }

        foreach ($message as $value){
            $likeMode=new Like();
            $value->like=$likeMode->getCount($value->id);
            if(isset( $comments[$value->id])){
                $value->comments=$comments[$value->id];
            }else{
                $value->comments=array();
            }


        }
        return view('home',['data' => $message,'time'=>$time]);
    }

    //点赞接口
    public function addlike(Request $request){
        $this->middleware('auth');
        //dd(Auth::id());
        if(Auth::id()){
            $uid=Auth::id();
            $mid=$request->input('mid',0);
            $likeMode=new Like();
            $info=$likeMode->addLike($mid,$uid);
            if($info==1){
                $data['info']=1;
                $data['code']=200;
                $data['message']='点赞成功';
            }else{
                $data['info']=2;
                $data['code']=200;
                $data['message']='取消点赞成功';
            }
        }else{
            $data['code']=402;
            $data['message']='请登录';
        }
        return $data;
    }

    //评论接口
    public function comment(Request $request){
        $this->middleware('auth');
        if(Auth::id()){
            $uid=Auth::id();
            $mid=$request->input('mid',0);
            $comment=$request->input('comment',0);
            $commentMode=new Comment();
            $data['m_id']=$mid;
            $data['message']=$comment;
            $data['c_uid']=$uid;
            $data['r_uid']=$uid;
            $data['creation_time']=date('Y-m-d H:i:s');
            $data['update_time']=date('Y-m-d H:i:s');
            $data['status']=$uid;
            $info=$commentMode->addComment($data);
            if($info){
                $commentdata=$commentMode->getOneComment($info);
                $data['code']=200;
                $data['message']='评论成功';
                $data['c_image']=asset('manager/'.$commentdata->c_image);
                $data['c_name']=$commentdata->c_name;
                $data['creation_time']=$commentdata->creation_time;
                $data['message']=$commentdata->message;


            }else{
                $data['code']=401;
                $data['message']='评论失败';
            }
        }else{
            $data['code']=402;
            $data['message']='请登录';
        }
        return $data;
    }



}
