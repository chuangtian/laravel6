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
        if($page==1){
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
        if($page>=2){
            $str='';
            foreach ($message as $value){
                $str.=' <div class="card card-widget">
                                <div class="card-header">
                                    <div class="user-block">
                                        <img class="img-circle" src="'.$value->u_image.'" alt="User Image">
                                        <span class="username"><a href="#">'.$value->name.'</a></span>
                                        <span class="description">发布时间 - '.$value->creation_time.'</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p>'.$value->message.'</p>';
                                    foreach($value->image as $imagea){
                                        if($imagea){
                                            $str.='<img class="img-fluid pad" src="'.$imagea.'" alt="Photo">';
                                        }
                                    }
                                    $str.='<p></p>

                                    <button type="button" class="btn btn-default btn-sm"   onclick="imagesubmit('.$value->id.')"><i class="far fa-thumbs-up"></i> Like</button>
                                    <span class="float-right text-muted"><span id="l'.$value->id.'">'.$value->like.'</span> 点赞 - <span id="c'.$value->id.'">'.count($value->comments) .'</span> 评论</span>
                                </div>
                                <div class="card-footer card-comments">
                                    <div id="addcomment'.$value->id.'">';
                                        foreach ($value->comments as $comment){
                                            $str.='<div class="card-comment">
                                                    <!-- User image -->
                                                    <img class="img-circle img-sm" src="'.asset('manager/'.$comment->c_image).'" alt="User Image">
                                                    <div class="comment-text">
                                                    <span class="username">
                                                      '.$comment->c_name.'
                                                      <span class="text-muted float-right">'.$comment->creation_time.'</span>
                                                    </span><!-- /.username -->
                                                        '.$comment->message.'
                                                    </div>
                                                    <!-- /.comment-text -->
                                                </div>';
                                        }
                                        $str.='</div>';
                                        $this->middleware('auth');
                                        if(Auth::id()){
                                            $str.='<div class="card-footer">
                                                <form  name="form" id="fromdata" enctype="multipart/form-data" onsubmit="return sub('.$value->id.')">
                                                    <img class="img-fluid img-circle img-sm" src="'. asset('manager/'.Auth::user()->image).'" alt="Alt Text">
                                                    <!-- .img-push is used to add margin to elements next to floating images -->
                                                    <div class="img-push">
                                                        <input type="hidden" name="messageid" id="messageid{{$value->id}}" value="'.$value->id.'">
                                                        <input type="text" class="form-control form-control-sm" id="comment'.$value->id.'" value="" placeholder="按Enter发表评论">
                                                    </div>
                                                </form>
                                            </div>';
                                        }
                                         $str.='</div>
                                </div>';
            }
            $da['code']=200;
            $da['message']=$str;
            return $da;
        }

        return view('home',['data' => $message,'time'=>$time,'lastPage'=>$message->lastPage()]);
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
