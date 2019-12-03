<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use phpDocumentor\Reflection\Types\Array_;
use App\Models\Comment;

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
    public function index()
    {

        //发送的消息获取
        $messageModel=new Message();
        //查询的朋友圈
        $message=$messageModel->getMessage();
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

            if(isset( $comments[$value->id])){
                $value->comments=$comments[$value->id];
            }else{
                $value->comments=array();
            }


        }
        //($message);
        return view('home',['data' => $message]);
    }
}
