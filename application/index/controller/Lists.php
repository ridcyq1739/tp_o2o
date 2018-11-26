<?php

namespace app\index\controller;

use think\Controller;

class Lists extends Base
{
    //列表页
    public function index()
    {
        $firstCatIds = [];
        $categorys = model('Category')->getNormalFirstCategory();
        foreach ($categorys as $category) {
            $firstCatIds[] = $category->id;
        }
        $id = input('get.id',0,'intval');
        $data = [];
        if(in_array($id,$firstCatIds)){//一级分类
            //todo
            $categoryParentId = $id;
            $data['category_id'] = $id;
        }elseif($id){//二级分类
            //获取二级分类
            $category = model('Category')->get($id);
            if(!$category || $category->status != 1){
                $this->error('数据不合法');
            }
            $categoryParentId = $category->parent_id;
            $data['se_category_id'] = $id;
        }else{//0
            $categoryParentId = 0;
        }
        $sedcategorys = [];
        //获取父类的所有子类
        if($categoryParentId){
            $sedcategorys = model('Category')->getFirstCategorys($categoryParentId);
        }
        //
        $orders = [];
        $order_sales = input('order_sales','');
        $order_price = input('order_price','');
        $order_time = input('order_time','');
        if(!empty($order_sales)){
            $order_flag = 'order_sales';
            $orders['order_sales'] = $order_sales;
        }elseif(!empty($order_price)){
            $order_flag = 'order_price';
            $orders['order_price'] = $order_price;
        }elseif(!empty($order_time)){
            $order_flag = 'order_time';
            $orders['order_time'] = $order_time;
        }else{
            $order_flag = '';
        }
        $data['city_id'] = $this->city->id;
        //根据上面条件来查询商品列表数据
        $deals = model('Deal')->getDealByCondition($data,$orders);
        $viewData = [
            'categorys' => $categorys,
            'sedcategorys' => $sedcategorys,
            'id' => $id,
            'categoryParentId' => $categoryParentId,
            'orderflag' => $order_flag,
            'deals' => $deals
        ];
        $this->assign($viewData);
        return view();
    }
}
