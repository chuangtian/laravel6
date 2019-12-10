<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Video extends Model
{
    public $table='video';
    //添加数据
    public function addVideo($data){
        $info=DB::table($this->table)->insert($data);
        return $info;
    }

    //获取数据
    public function getVideo(){
        $data=DB::table($this->table)->orderBy('id','desc')->get();
        return $data;
    }

    //获取数据
    public function delVideo($id){
        $info=DB::table($this->table)->delete($id);
        return $info;
    }
    //获取数据
    public function oneVideo($id){
        $data=DB::table($this->table)->where('id',$id)->first();
        return $data;
    }
}
