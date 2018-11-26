<?php

namespace app\admin\controller;

use think\Controller;

class City extends Base
{
    //城市首页
    public function index()
    {
        $parentId = input('get.parent_id',0);
        $citys = model('City')->getFirstCitys($parentId);
        $viewData = [
            'citys' => $citys
        ];
        $this->assign($viewData);
        return view();
    }

    //城市添加页面
    public function add()
    {
        if(request()->isAjax()){
            $data = [
                'parent_id' => input('post.parent_id'),
                'name' => input('post.name'),
                'uname' => input('post.uname')
            ];
            $validate = new \app\common\validate\City();
            if(!$validate->scene('add')->check($data)){
                $this->error($validate->getError());
            }
            $result = model('City')->add($data);
            if($result){
                $this->success('保存成功','admin/category/add');
            }else{
                $this->error('保存失败');
            }
        }
        $citys = model('City')->getNormalFirstCity();
        $viewData = [
            'citys' => $citys
        ];
        $this->assign($viewData);
        return view();
    }

    //城市编辑页面
    public function edit()
    {
        if(request()->isAjax()){
            $data = [
                'id' => input('id'),
                'parent_id' => input('parent_id'),
                'name' => input('name'),
                'uname' => input('uname')
            ];
            $validate = new \app\common\validate\City();
            if(!$validate->scene('edit')->check($data)){
                $this->error($validate->getError());
            }
            $result = model('City')->edit($data);
            if($result){
                $this->success('更新成功','admin/city/index');
            }else{
                $this->error('更新失败');
            }
        }
        $cityInfo = model('City')->find(input('id'));
        $citys = model('City')->getNormalFirstCity();
        $viewData = [
            'citys' => $citys,
            'cityInfo' => $cityInfo
        ];
        $this->assign($viewData);
        return view();
    }

    //排序
    public function listorder()
    {
        if(request()->isAjax()){
            $data = [
                'id' => input('id'),
                'listorder' => input('listorder')
            ];
            $city = model('City')->find($data['id']);
            $result = $city->save($data);
            if($result){
                $this->success('更新成功');
            }else{
                $this->error('更新失败');
            }
        }
    }

    //修改状态
    public function status()
    {
        if(request()->isAjax()){
            $data = [
                'id' => input('id'),
                'status' => input('status')==1?0:1
            ];
            $validate = new \app\common\validate\City();
            if(!$validate->scene('status')->check($data)){
                $this->error($validate->getError());
            }
            $cityInfo = model('City')->find($data['id']);
            $result = $cityInfo->save($data);
            if($result){
                $this->success('操作成功');
            }else{
                $this->error('操作失败');
            }
        }
    }

    //删除stauts=-1
    public function del()
    {
        if(request()->isAjax()){
            $data = [
                'id' => input('id')
            ];
            $cityInfo = model('City')->find($data['id']);
            $cityInfo->status = -1;
            $result = $cityInfo->save();
            if($result){
                $this->success('删除成功');
            }else{
                $this->error('删除失败');
            }
        }
    }
}
