<?php

namespace app\api\controller;

use think\Controller;
use think\Request;

class Category extends Controller
{
    //二级分类
    public function getCategorysByParentId()
    {
        $id = input('id',0,'intval');
        if(!$id){
            $this->error('id不合法');
        }
        // 通过id获取二级城市
        $categorys = model('Category')->getFirstCategorys($id);
        if(!$categorys){
            $this->error('错误');
        }
        return show(1,'success',$categorys);
    }
}
