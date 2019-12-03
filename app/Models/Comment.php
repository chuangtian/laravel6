<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Comment extends Model
{
    public $table='comment';
    //根据朋友圈ID获取评论
    public function getComment($m_ids){
        $data=DB::table($this->table)
            ->whereIn('m_id',$m_ids)
            ->get();
        return $data;
    }
}
