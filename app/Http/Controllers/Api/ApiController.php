<?php

namespace App\Http\Controllers\Api;

use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use mysql_xdevapi\Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use App\Article;
use App\Events\PublicBroadcastEvent;
use App\Events\TestBroadcastingEvent;
use App\Events\PushMsgEvent;
use App\Events\PrivateEvent;


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

    //测试
    public function tes(){
//        Redis::set('name', 'hahahaha');
//        $a=Redis::get('name');
        //dd($a);
        return view('test');

    }

    public function tt(){
        echo "ok";
//        $id=Auth::id();
//        dd($id);
        $article = Users::where([
            ['id', 1]
        ])->first();
        //dd($article);
        // 广播事件
        // 也可以写 event(new PublicBroadcastEvent($article));但broadcast()多了一个toOthers()方法更加方便
        //broadcast(new PublicBroadcastEvent($article));

        $test['id']=50;
        $test['msg']='sdadasdasdad';
        $test2['id']=52;
        $test2['msg']='hhhhhhhh';
        broadcast(new PushMsgEvent($test));
        broadcast(new PrivateEvent($article,$test2));
    }


}
