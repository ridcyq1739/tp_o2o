<?php

namespace app\admin\controller;

use think\Controller;

class Order extends Base
{
    public function index()
    {
        $orders = model('Order')->where(['status'=>['neq',-1]])->paginate(10);
        $data = input('get.');
        $sdata = [];
        if ($data){
            if(!empty($data['start_time']) && !empty($data['end_time']) && strtotime($data['end_time'])>strtotime($data['start_time'])){
                $sdata['create_time'] = [
                    ['gt',strtotime($data['start_time'])],
                    ['lt',strtotime($data['end_time'])]
                ];
            }
            if(!empty($data['username'])){
                $sdata['username'] = ['like','%'.$data['username'].'%'];
            }
            $orders = model('Order')->getNormalOrders($sdata);
        }
        $viewData = [
            'orders' => $orders
        ];
        $this->assign($viewData);
        return view();
    }
}
