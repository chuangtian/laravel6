<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Like extends Model
{
    public $table='like';

    public function addLike($mid,$uid){
        //查询有没有点赞
        $data=DB::table($this->table)
            ->where('m_id',$mid)
            ->where('uid',$uid)
            ->first();
        if($data){
            if ($data->status==1){
                $info=DB::table($this->table)->where('id',$data->id)->update(array('status'=>2));
                $s=2;
            }else{
                $info=DB::table($this->table)->where('id',$data->id)->update(array('status'=>1));
                $s=1;
            }
        }else{
            $datas['m_id']=$mid;
            $datas['uid']=$uid;
            $datas['creation_time']=date('Y-m-d H:i:s');
            $datas['update_time']=date('Y-m-d H:i:s');
            $datas['status']=1;
            $info=DB::table($this->table)->insert($datas);
            $s=1;
        }
        return $s;
    }

    //获取总点赞数量
    public function getCount($mid){
        $users = DB::table($this->table)->where('m_id',$mid)->where('status',1)->count();
        return$users;
    }

    //根据朋友圈ID统计评论数
    public function getMeCount(array $ids)
    {
        $data=DB::table($this->table)
            ->whereIn('m_id',$ids)
            ->count();
        return $data;
    }
}
