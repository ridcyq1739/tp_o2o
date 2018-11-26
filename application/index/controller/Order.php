<?php

namespace app\index\controller;

use think\Controller;

class Order extends Base
{
    //订单
    public function index()
    {
        if(!$this->getLoginUser()){
            $this->error('请登录','index/user/login');
        }
        $id = input('id',0,'intval');
        if(!$id){
            $this->error('参数不合法');
        }
        $count = input('count',1,'intval');
        $deal = model('Deal')->get($id);
        if(!$deal || $deal->status != 1){
            $this->error('商品不存在');
        }
        $deal = $deal->toArray();
        $viewData = [
            'deal' => $deal,
            'count' => $count
        ];
        $this->assign($viewData);
        return view();
    }

    //生成订单
    public function crorder()
    {

        $user = $this->getLoginUser();
        if(!$user){
            $this->error('请登录','index/user/login');
        }
        $id = input('post.id',0,'intval');
        if(!$id){
            $this->error('参数不合法');
        }
        $dealCount = input('post.deal_count',0,'intval');
        $totalPrice = input('post.total_price',0,'intval');
        $deal = model('Deal')->find($id);
        if(!$deal || $deal->status != 1){
            $this->error('商品不存在');
        }
        if (empty($_SERVER['HTTP_REFERER'])){
            $this->error('请求不合法');
        }
        $orderSn = setOrderSn();
        //组装入库数据
        $data = [
            'out_trade_no' => $orderSn,
            'user_id' => $user->id,
            'username' => $user->username,
            'deal_id' => $id,
            'deal_count' => $dealCount,
            'total_price' => $totalPrice,
            'referer' => $_SERVER['HTTP_REFERER']
        ];
        try{
            $orderId = model('Order')->add($data);
        }catch (\Exception $e){
            $this->error('订单生成失败');
        }
        $datas['id'] = $orderId;
        $datas['code'] = 1;
        $datas['msg'] = '订单生成成功,是否前往支付';
        $this->success($datas);
    }
}
