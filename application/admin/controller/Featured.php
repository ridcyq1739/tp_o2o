<?php

namespace app\admin\controller;

use think\Controller;

class Featured extends Base
{
    //首页
    public function index()
    {
        $type = input('get.type',0,'intval');
        $featureds = model('Featured')->getFeaturedByType($type);
        $types = config('featured.featured_type');
        $viewData = [
            'types' => $types,
            'featureds' => $featureds,
            'type' => $type
        ];
        $this->assign($viewData);
        return view();
    }

    //添加
    public function add()
    {
        if(request()->isAjax()){
            $data = input('post.');
            $validate = new \app\common\validate\Featured();
            if(!$validate->scene('add')->check($data)){
                $this->error($validate->getError());
            }
            $id = model('Featured')->add($data);
            if($id){
                $this->success('添加成功');
            }else{
                $this->error('添加失败');
            }
        }
        $types = config('featured.featured_type');
        $viewData = [
            'types' => $types
        ];
        $this->assign($viewData);
        return view();
    }

    //修改状态
    public function status()
    {
        if(request()->isAjax()){
            $data = [
                'id' => input('id'),
                'status' => input('status') == 0?1:0
            ];
            $featured = model('Featured')->find($data['id']);
            $result = $featured->save($data);
            if($result){
                $this->success('操作成功');
            }else{
                $this->error('操作失败');
            }
        }
    }

    //删除
    public function del()
    {
        if(request()->isAjax()){
            $data = [
                'id' => input('id')
            ];
            $featured = model('Featured')->find($data['id']);
            $featured->status = -1;
            $result = $featured->save();
            if($result){
                $this->success('删除成功');
            }else{
                $this->error('删除失败');
            }
        }
    }
}
