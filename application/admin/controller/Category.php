<?php

namespace app\admin\controller;

use think\Controller;

class Category extends Base
{
    //分类首页
    public function index()
    {
        $parentId = input('get.parent_id',0);
        $categorys = model('Category')->getFirstCategorys($parentId);
        $viewData = [
            'categorys' => $categorys
        ];
        $this->assign($viewData);
        return view();
    }

    //添加分类
    public function add()
    {
        if(request()->isAjax()){
            $data = [
                'parent_id' => input('post.parent_id'),
                'name' => input('post.name')
            ];
            $validate = new \app\common\validate\Category();
            if(!$validate->scene('add')->check($data)){
                $this->error($validate->getError());
            }
            $result = model('Category')->add($data);
            if($result){
                $this->success('保存成功','admin/category/add');
            }else{
                $this->error('保存失败');
            }
        }
        $categorys = model('Category')->getNormalFirstCategory();
        $viewData = [
            'categorys' => $categorys
        ];
        $this->assign($viewData);
        return view();
    }

    //编辑分类
    public function edit()
    {
        if(request()->isAjax()){
            $data = [
                'id' => input('id'),
                'parent_id' => input('parent_id'),
                'name' => input('name')
            ];
            $validate = new \app\common\validate\Category();
            if(!$validate->scene('edit')->check($data)){
                $this->error($validate->getError());
            }
            $result = model('Category')->edit($data);
            if($result){
                $this->success('更新成功');
            }else{
                $this->error('更新失败');
            }
        }
        $categoryInfo = model('Category')->find(input('id'));
        $categorys = model('Category')->getNormalFirstCategory();
        $viewData = [
            'categorys' => $categorys,
            'categoryInfo' => $categoryInfo
        ];
        $this->assign($viewData);
        return view();
    }

    //排序逻辑
    public function listorder()
    {
        if(request()->isAjax()){
            $data = [
                'id' => input('id'),
                'listorder' => input('listorder')
            ];
            $category = model('Category')->find($data['id']);
            $result = $category->save($data);
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
            $validate = new \app\common\validate\Category();
            if(!$validate->scene('status')->check($data)){
                $this->error($validate->getError());
            }
            $categoryInfo = model('Category')->find($data['id']);
            $result = $categoryInfo->save($data);
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
            $categoryInfo = model('Category')->find($data['id']);
            $categoryInfo->status = -1;
            $result = $categoryInfo->save();
            if($result){
                $this->success('删除成功');
            }else{
                $this->error('删除失败');
            }
        }
    }
}
