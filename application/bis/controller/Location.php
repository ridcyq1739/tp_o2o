<?php

namespace app\bis\controller;

use think\Controller;

class Location extends Base
{
    //首页
    public function index()
    {

        $account = $this->account;
        $locations = model('BisLocation')->where(['status'=>['neq',-1],'bis_id'=>$account['bis_id']])->order('create_time','desc')->paginate(10);
        $viewData = [
            'locations' => $locations,
        ];
        $this->assign($viewData);
        return view();
    }

    //新增
    public function add()
    {
        if(request()->isAjax()){
            //门店入库操作
            $data = input('post.');
            $validate = new \app\common\validate\BisLocation();
            if(!$validate->scene('sq')->check($data)){
                $this->error($validate->getError());
            }
            $lnglat = \Map::getLngLat($data['address']);
            if(empty($lnglat) || $lnglat['status'] != 0 || $lnglat['result']['precise']!=0){
                $this->error('无法获取数据，或者匹配的不精确');
            }
            $data['cat'] = '';
            if(!empty($data['se_category_id'])) {
                $data['cat'] = implode('|', $data['se_category_id']);
            }
            $bisId = $this->getLoginUser()->bis_id;
            $locationData = [
                'bis_id' => $bisId,
                'name' => $data['name'],
                'tel' => $data['tel'],
                'logo' => $data['logo'],
                'contact' => $data['contact'],
                'category_id' => $data['category_id'],
                'category_path' => $data['category_id'].','.$data['cat'],
                'city_id' => $data['city_id'],
                'city_path' => empty($data['se_city_id'])?data['city_id']:$data['city_id'].','.$data['se_city_id'],
                'address' => $data['address'],
                'api_address' => $data['address'],
                'open_time' => $data['open_time'],
                'content' => empty($data['content'])?'':$data['content'],
                'is_main' => 0,//代表分店信息
                'xpoint' => empty($lnglat['result']['location']['lng'])?'':$lnglat['result']['location']['lng'],
                'ypoint' => empty($lnglat['result']['location']['lat'])?'':$lnglat['result']['location']['lat'],
            ];
            $locationId = model('BisLocation')->add($locationData);
            if($locationId){
                $this->success('门店申请成功');
            }else{
                $this->error('门店申请失败');
            }
        }
        $citys = model('City')->getNormalFirstCity();
        $categorys = model('Category')->getNormalFirstCategory();
        $viewData = [
            'citys' => $citys,
            'categorys' => $categorys
        ];
        $this->assign($viewData);
        return view();
    }

    //分店申请信息
    public function fddetail()
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
        $locationData = model('BisLocation')->find($id);
        return $this->fetch('',[
            'citys' => $citys,
            'categorys' => $categorys,
            'locationData' => $locationData,
        ]);
    }

    //删除分店操作
    public function delfd()
    {
        $id = input('id');
        $location = model('BisLocation')->find($id);
        $location->status = -1;
        $result = $location->save();
        if($result){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }
}
