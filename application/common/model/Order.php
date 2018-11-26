<?php

namespace app\common\model;

use think\Model;

class Order extends Model
{
    //添加
    public function add($data)
    {
        $data['status'] = 1;
        $result = $this->save($data);
        return $result;
    }

    //搜索订单
    public function getNormalOrders($sdata = []){
        $sdata['status'] = ['neq',-1];
        $order = ['id'=>'desc'];
        $result = $this->where($sdata)->order($order)->paginate(10);
        return $result;
    }
}
