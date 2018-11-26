<?php

namespace app\admin\controller;

use think\Controller;

class Area extends Base
{
    //首页
    public function index()
    {
        $parentId = input('get.parent_id',0);
        $areas = model('Area')->getFirstAreas($parentId);
        $viewData = [
            'areas' => $areas
        ];
        $this->assign($viewData);
        return view();
    }

    //添加
    public function add()
    {
        $areas = model('Area')->getNormalFirstArea();
        $pres = model('City')->where('parent_id',0)->order('id','desc')->select();
        $citys = [];
        if(request()->isAjax()){
            $data = [
                'pre' => input('pre'),
            ];
            $validate = new \app\common\validate\Area();
            if(!$validate->scene('change_pre')->check($data)){
                $this->error($validate->getError());
            }
            $opt = '<option>--请选择城市--</option>';
            $citys = model('City')->where('parent_id',$data['pre'])->order('id','desc')->select();
            foreach($citys as $key=>$val){
                $opt .= "<option value='{$val['id']}'>{$val['name']}</option>";
            }
            $this->success($opt);
        }
        $viewData = [
            'areas' => $areas,
            'pres' => $pres,
            'citys' => $citys,
        ];
        $this->assign($viewData);
        return view();
    }

    //保存操作
    public function save()
    {
        if(request()->isAjax()){
            $data = [
                'parent_id' => input('post.parent_id'),
                'name' => input('post.name'),
                'pre' => input('pre'),
                'city_id' => input('city_id')
            ];
            $validate = new \app\common\validate\Area();
            if(!$validate->scene('save')->check($data)){
                $this->error($validate->getError());
            }
            unset($data['pre']);
            $result = model('Area')->add($data);
            if($result){
                $this->success('保存成功');
            }else{
                $this->error('保存失败');
            }
        }
    }

    //编辑操作
    public function edit()
    {
        $area = model('Area')->with('city')->find(input('id'));
        $citys = model('City')->where('parent_id',$area['city']['parent_id'])->select();
        $pres = model('City')->where('parent_id',0)->order('id','desc')->select();
        $areas = model('Area')->getNormalFirstArea();
        if(request()->isAjax()){
            $data = [
                'pre' => input('pre'),
            ];
            $validate = new \app\common\validate\Area();
            if(!$validate->scene('change_pre')->check($data)){
                $this->error($validate->getError());
            }
            $opt = '<option>--请选择城市--</option>';
            $citys = model('City')->where('parent_id',$data['pre'])->order('id','desc')->select();
            foreach($citys as $key=>$val){
                $opt .= "<option value='{$val['id']}'>{$val['name']}</option>";
            }
            $this->success($opt);
        }
        $viewData = [
            'areas' => $areas,
            'pres' => $pres,
            'area' => $area,
            'citys' => $citys
        ];
        $this->assign($viewData);
        return view();
    }

    //更新操作
    public function update()
    {
        if(request()->isAjax()){
            $data = [
                'id' => input('id'),
                'parent_id' => input('parent_id'),
                'name' => input('name'),
                'pre' => input('pre'),
                'city_id' => input('city_id')
            ];
            $validate = new \app\common\validate\Area();
            if(!$validate->scene('up')->check($data)){
                $this->error($validate->getError());
            }
            unset($data['pre']);
            $result = model('Area')->update_data($data);
            if($result){
                $this->success('更新成功');
            }else{
                $this->error('更新失败');
            }
        }
    }

    //排序
    public function listorder()
    {
        if(request()->isAjax()){
            $data = [
                'id' => input('id'),
                'listorder' => input('listorder')
            ];
            $area = model('Area')->find($data['id']);
            $result = $area->save($data);
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
            $validate = new \app\common\validate\Area();
            if(!$validate->scene('status')->check($data)){
                $this->error($validate->getError());
            }
            $area = model('Area')->find($data['id']);
            $result = $area->save($data);
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
            $area = model('Area')->find($data['id']);
            $area->status = -1;
            $result = $area->save();
            if($result){
                $this->success('删除成功');
            }else{
                $this->error('删除失败');
            }
        }
    }
}
