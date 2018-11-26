<?php

namespace app\bis\controller;

use think\Controller;

class Deal extends Base
{
    //首页
    public function index()
    {
        $bisId = $this->getLoginUser()->bis_id;
        $deals = model('Deal')->where(['status'=>['neq',-1],'bis_id'=>$bisId])->paginate(10);
        $viewData = [
            'deals' => $deals
        ];
        $this->assign($viewData);
        return view();
    }

    //添加
    public function add()
    {
        $bisId = $this->getLoginUser()->bis_id;
        if(request()->isAjax()){
            // 走插入逻辑
            $data = input('post.');
            //严格校验书卷
            $validate = new \app\common\validate\Deal();
            if(!$validate->scene('add')->check($data)){
                $this->error($validate->getError());
            }
            $location = model('BisLocation')->where(['bis_id'=> $bisId,'is_main'=>1])->find();
            $deals = [
                'bis_id' => $bisId,
                'name' => $data['name'],
                'image' => $data['image'],
                'category_id' => $data['category_id'],
                'se_category_id' => empty($data['se_category_id'])?'':implode(',',$data['se_category_id']),
                'city_id' => $data['city_id'],
                'se_city_id' => $data['se_city_id'],
                'location_ids' => empty($data['location_ids'])?'':implode(',',$data['location_ids']),
                'start_time' => strtotime($data['start_time']),
                'end_time' => strtotime($data['end_time']),
                'total_count' => $data['total_count'],
                'origin_price' => $data['origin_price'],
                'current_price' => $data['current_price'],
                'coupons_begin_time' => strtotime($data['coupons_begin_time']),
                'coupons_end_time' => strtotime($data['coupons_end_time']),
                'description' => $data['desc'],
                'notes' => $data['notes'],
                'bis_account_id' => $this->getLoginUser()->id,
                'xpoint' => $location->xpoint,
                'ypoint' => $location->ypoint
            ];
            $id = model('Deal')->add($deals);
            if($id){
                $this->success('添加成功','bis/deal/index');
            }else{
                $this->error('添加失败');
            }
        }
        $citys = model('City')->getNormalFirstCity();
        $categorys = model('Category')->getNormalFirstCategory();
        $bisLocations = model('BisLocation')->getNormailLocationByBisId($bisId);
        $viewData = [
            'citys' => $citys,
            'categorys' => $categorys,
            'bisLocations' => $bisLocations
        ];
        $this->assign($viewData);
        return view();
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
