<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Chat extends Model
{
    public $table='chat';
    public function add($data){
        $info=DB::table($this->table)->insertGetId($data);
        return $info;
    }

    public function getOne($id){
        $data=DB::table($this->table.' as c')
            ->select('c.*','u.name as f_name','u.image as f_image')
            ->leftJoin('users as u', 'u.id', '=', 'c.f_id')
            ->where('c.id',$id)
            ->first();
        return $data;
    }

    public function getAll($f_id,$t_id){
        $data=DB::table($this->table.' as c')
            ->select('c.*','u.name as f_name','u.image as f_image')
            ->leftJoin('users as u', 'u.id', '=', 'c.f_id')
//            ->where('c.f_id',$f_id)
//            ->where('c.t_id',$t_id)
            ->where([
                ['c.f_id',$f_id],
                ['c.t_id',$t_id]
            ])
            ->orWhere([
                    ['c.f_id',$t_id],
                    ['c.t_id',$f_id]
                ])
            ->get();
        return $data;
    }
}
