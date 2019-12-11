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
        $imagecheck=$request->input('imagecheck',array());
        $image='';

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
        $token=$this->test($request);
        return view('admin.bvideo',['xd'=>22,'id'=>$id,'token'=>$token]);
    }

    public function getVideoUrl(Request $request){
        $id=$request->id;
        $videoModel=new Video();
        $data=$videoModel->oneVideo($id);
        return redirect(asset($data->url));
    }

    public function test(Request $request){
        $userId = '7e527c151b';       // polyv 提供的服务器间的通讯验证
        $secretkey = 'lmQy1ZS0Zn';     // polyv 提供的接口调用签名访问的key
        $videoId = '7e527c151b2c81a42aeb8ec6e707f63d_7';  // 视频对应vid
        $ts = time() * 1000;      // 时间戳
        $viewerIp = $this->get_client_ip();  // 用户 ip
        $viewerId = '1';      // 自定义用户 id
        $viewerName = urlencode('田闯');  // 用户昵称, 若值为中文需要urlencode('张三')
        $extraParams = 'HTML5';  // 自定义参数

        /* 将参数 $userId、$secretkey、$videoId、$ts、$viewerIp、$viewerIp、$viewerId、$viewerName、$extraParams
            按照ASCKII升序 key + value + key + value ... +value 拼接
        */
        $concated =  'extraParams'.$extraParams.'ts'.$ts.'userId'.$userId.'videoId'.$videoId.'viewerId'.$viewerId.'viewerIp'.$viewerIp.'viewerName'.$viewerName;

// 再首尾加上 secretkey
        $plain = $secretkey.$concated.$secretkey;

// 取大写MD5
        $sign = strtoupper(md5($plain));



// 然后将下列参数用post请求  https://hls.videocc.net/service/v1/token 获取 token
        $url = 'https://hls.videocc.net/service/v1/token';
        $data = array('userId' => $userId, 'videoId' => $videoId, 'ts' => $ts, 'viewerIp' => $viewerIp, 'viewerName' => $viewerName, 'extraParams' => $extraParams, 'viewerId' => $viewerId, 'sign' => $sign);

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        // 获取返回结果的 token, 再传入 playsafe 中播放加密视频
        $token = json_decode($result)->data->token;
        return $token;
    }

    public function get_client_ip() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        }
        return $ipaddress;
    }





}
