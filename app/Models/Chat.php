<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
            ->leftJoin('users as u', 'u.id', '=', 'c.f_uid')
            ->where('c.id',$id)
            ->first();
        return $data;
    }
}
