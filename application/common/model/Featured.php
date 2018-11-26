<?php

namespace app\common\model;

use think\Model;

class Featured extends BaseModel
{
    //根据type获取推荐
    public function getFeaturedByType($type){
        $data = [
            'type' => $type,
            'status' => ['neq',-1]
        ];

        $order = [
            'id' => 'desc'
        ];

        return $this->where($data)->order($order)->paginate(10);
    }
}
