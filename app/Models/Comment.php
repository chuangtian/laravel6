<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Comment extends Model
{
    public $table='comment';
    //根据朋友圈ID获取评论
    public function getComment($m_ids){
        $data=DB::table($this->table.' as c')
            ->select('c.*','u.name as c_name','u.image as c_image','p.name as r_name','p.image as r_image')
            ->leftJoin('users as u', 'u.id', '=', 'c.c_uid')
            ->leftJoin('users as p', 'p.id', '=', 'c.r_uid')
            ->whereIn('m_id',$m_ids)
            ->get();
        return $data;
    }

    public function addComment($data){
        $info=DB::table($this->table)->insertGetId($data);
        return $info;
    }
    public function getOneComment($id){
        $data=DB::table($this->table.' as c')
            ->select('c.*','u.name as c_name','u.image as c_image','p.name as r_name','p.image as r_image')
            ->leftJoin('users as u', 'u.id', '=', 'c.c_uid')
            ->leftJoin('users as p', 'p.id', '=', 'c.r_uid')
            ->where('c.id',$id)
            ->first();
        return $data;
    }
}
