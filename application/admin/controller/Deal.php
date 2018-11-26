<?php

namespace app\admin\controller;

use think\Controller;

class Deal extends Base
{
    //首页
    public function index()
    {
        $categorys = model('Category')->getNormalFirstCategory();
        $citys = model('City')->getNormalCitys();
        $deals = [];
        $data = input('get.');
        if ($data){
            if(!empty($data['start_time']) && !empty($data['end_time']) && strtotime($data['end_time'])>strtotime($data['start_time'])){
                $sdata['create_time'] = [
                    ['gt',strtotime($data['start_time'])],
                    ['lt',strtotime($data['end_time'])]
                ];
            }
            if(!empty($data['category_id'])){
                $sdata['category_id'] = $data['category_id'];
            }
            if(!empty($data['city_id'])){
                $sdata['se_city_id'] = $data['city_id'];
            }
            if(!empty($data['name'])){
                $sdata['name'] = ['like','%'.$data['name'].'%'];
            }
            $deals = model('Deal')->getNormalDeals($sdata);
        }
        $viewData = [
            'categorys' => $categorys,
            'citys' => $citys,
            'deals' => $deals,
            'category_id' => empty($data['category_id'])?'':$data['category_id'],
            'city_id' => empty($data['city_id'])?'':$data['city_id'],
            'name' => empty($data['name'])?'':$data['name'],
            'start_time' => empty($data['start_time'])?'':$data['start_time'],
            'end_time' => empty($data['end_time'])?'':$data['end_time'],
        ];
        $this->assign($viewData);
        return view();
    }
    //审核
    public function deallist()
    {
        $deals = model('Deal')->with('city','category')->where(['status'=>['neq',-1]])->paginate(10);
        $viewData = [
            'deals' => $deals,
        ];
        $this->assign($viewData);

        return view();
    }
    //状态
    public function status()
    {
        if(request()->isAjax()){
            $data = [
                'id' => input('id'),
                'status' => input('status')==1?0:1
            ];
            $deal = model('Deal')->find($data['id']);
            $result = $deal->save($data);
            if($result){
                $this->success('操作成功');
            }else{
                $this->error('操作失败');
            }
        }
    }
    //详情
    public function detail()
    {
        $id = input('get.id');
        if(empty($id)) {
            return $this->error('ID错误');
        }
        //获取一级城市的数据
        $citys = model('City')->getNormalFirstCity();
        //获取一级栏目的数据
        $categorys = model('Category')->getNormalFirstCategory();
        // 获取商户数据
        $deal = model('Deal')->find($id);
        return $this->fetch('',[
            'citys' => $citys,
            'categorys' => $categorys,
            'deal' => $deal,
        ]);
        return view();
    }
    //删除
    public function del()
    {
        $id = input('id');
        $deal = model('Deal')->find($id);
        $deal->status = -1;
        $result = $deal->save();
        if($result){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
        return view();
    }
}
