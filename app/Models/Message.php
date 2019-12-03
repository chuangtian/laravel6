<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginato;

class Message extends Model
{
    public $table='message';
    //添加数据
    public function addMessage($data){
        $info=DB::table($this->table)->insert($data);
        return $info;
    }
    //获取数据
    public function getMessage(){
        $info=DB::table($this->table.' as m')
            ->select('m.*','u.name','u.image as u_image')
            ->leftJoin('users as u', 'u.id', '=', 'm.u_id')
            ->where('status',2)
            ->orderBy('creation_time','desc')
            ->paginate(5);
        return $info;
    }
}
