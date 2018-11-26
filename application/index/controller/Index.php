<?php
namespace app\index\controller;

use think\Controller;

class Index extends Base
{
    public function index()
    {
        $main_slides = model('Featured')->where(['status'=>1,'type'=>0])->order('id','desc')->select();
        $right_slides = model('Featured')->where(['status'=>1,'type'=>1])->order('id','desc')->find();
        //获取商品分类数据
        $datas = model('Deal')->getNormalDealByCategoryCityId(1,$this->city->id);
        //获取四个子分类
        $meishicategorys = model('Category')->getNormalRecommendCategoryByParentId(1,4);
        $viewData = [
            'main_slides' => $main_slides,
            'right_slides' => $right_slides,
            'datas' => $datas,
            'meishicategorys' => $meishicategorys
        ];
        $this->assign($viewData);
        return view('index');
    }
}
