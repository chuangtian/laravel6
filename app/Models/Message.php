<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginato;
use phpDocumentor\Reflection\Types\Array_;

class Message extends Model
{
    public $table='message';
    //添加数据
    public function addMessage($data){
        $info=DB::table($this->table)->insert($data);
        return $info;
    }
    //获取数据
    public function getMessage($time){
        $info=DB::table($this->table.' as m')
            ->select('m.*','u.name','u.image as u_image')
            ->leftJoin('users as u', 'u.id', '=', 'm.u_id')
            ->where('m.status',2)
            ->where('m.creation_time','<',$time)
            ->orderBy('m.creation_time','desc')
            ->paginate(5);
        return $info;
    }

    //获取朋友圈总数
    public function count($id){
        $count=DB::table($this->table)->where('u_id',$id)->count();
        return $count;
    }

    //获取我朋友圈全部id
    public function getMeId($id){
        $data=DB::table($this->table)
            ->select('id')
            ->where('u_id',$id)
            ->get();
        $meIds=array();
        foreach ($data as $value){
            $meIds[]=$value->id;
        }
        return $meIds;
    }



}
