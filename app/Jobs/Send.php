<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

class Send implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $wxuin;
    private $message;
    private $from_UserName;
    private $to_UserName;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($wxuin,$message,$from_UserName,$to_UserName)
    {
        //
        $this->wxuin=$wxuin;
        $this->message=$message;
        $this->from_UserName=$from_UserName;
        $this->to_UserName=$to_UserName;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $wxinfo=DB::table('w_uinfo')->where('wxuin',$this->wxuin)->first();
        if(!$wxinfo){
            return '我知道你牛逼，但是请别闹';
        }
        $callback['post_url_header']=$wxinfo->post_url_header;
        $callback['https_header']=$wxinfo->https_header;
        $callback['Ret']['ret']=$wxinfo->ret;
        $callback['Ret']['skey']=$wxinfo->skey;
        $callback['Ret']['wxsid']=$wxinfo->wxsid;
        $callback['Ret']['wxuin']=$wxinfo->wxuin;
        $callback['Ret']['pass_ticket']=$wxinfo->pass_ticket;
        //获取post数据
        $post = $this->post_self($callback);
        $mes = urlencode($this->message);
        $sendmsg = $this->webwxsendmsg($post, $this->from_UserName, $callback['post_url_header'], $this->to_UserName, $mes);
        //dd($sendmsg);
        
    }

    /**
     * 获取post数据
     * @param array $callback
     * @return object $post
     */
    public function post_self($callback)
    {
        $post = new stdClass();
        $Ret = $callback['Ret'];
        $status = $Ret['ret'];
        if ($status == '1203') {
            $this->error('未知错误,请2小时后重试');
        }
        if ($status == '0') {
            $post->BaseRequest = array(
                'Uin' => $Ret['wxuin'],
                'Sid' => $Ret['wxsid'],
                'Skey' => $Ret['skey'],
                'DeviceID' => 'e' . rand(10000000, 99999999) . rand(1000000, 9999999),
            );

            $post->skey = $Ret['skey'];

            $post->pass_ticket = $Ret['pass_ticket'];

            $post->sid = $Ret['wxsid'];

            $post->uin = $Ret['wxuin'];
            //$post->https_header = $callback['https_header'];

            return $post;
        }
    }

    /**
     * 发送消息
     * @param $post
     * @param $post_url_header
     * @param $to 发送人
     * @param $word
     * @return array $data
     */
    public function webwxsendmsg($post, $userName, $post_url_header, $to, $word)
    {

//header("Content-Type: application/json; charset=UTF-8");
//header("Content-Type: application/x-www-form-urlencoded; charset=UTF-8");
        $url = $post_url_header . '/webwxsendmsg?pass_ticket=' . $post->pass_ticket;

//$clientMsgId = getMillisecond() * 1000 + rand(1000, 9999);//原方法
        $clientMsgId = time() * 1000 + rand(1000, 9999);//原方法
        //$init = json_decode($json, true);
        //$User = $init['User'];
        $params = array(
            'BaseRequest' => $post->BaseRequest,
            'Msg' => array(
                "Type" => 1,
                "Content" => $word,
                "FromUserName" => $userName,
                "ToUserName" => $to,
                "LocalID" => $clientMsgId,
                "ClientMsgId" => $clientMsgId
            ),
            'Scene' => 0,
        );


        $data = $this->sendCurlPost($url, $params, 1);
        //dd($params,$url,$data);
        return $data;
    }

    public function sendCurlPost($url, $data = '', $is_gbk = false, $timeout = 30, $CA = false)
    {
        $cacert = getcwd() . '/cacert.pem'; //CA根证书

        $SSL = substr($url, 0, 8) == "https://" ? true : false;

//$header = 'ContentType: application/json; charset=UTF-8';
        $header[] = 'ContentType: application/json;';
        $header[] = "charset:UTF-8";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout - 2);
        if ($SSL && $CA) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // 只信任CA颁布的证书
            curl_setopt($ch, CURLOPT_CAINFO, $cacert); // CA根证书（用来验证的网站证书是否是CA颁布）
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 检查证书中是否设置域名，并且是否与提供的主机名匹配
        } else if ($SSL && !$CA) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 信任任何证书
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 检查证书中是否设置域名
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:')); //避免data数据过长问题
        if ($data) {
            if ($is_gbk) {
                $data = urldecode(json_encode($data));

            } else {
                $data = urldecode(json_encode($data));
            }

            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

//curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); //data with URLEncode
        $ret = curl_exec($ch);
        curl_close($ch);
        return $ret;
    }


}

class stdClass {
}

