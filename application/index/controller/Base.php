<?php

namespace app\index\controller;

use think\Controller;

class Base extends Controller
{
    public $city = '';
    public $user = '';
    //初始化
    public function _initialize()
    {
        //城市数据
        $citys = model('City')->getNormalFirstCity();
        //用户数据
        $this->getLoginUser();
        $this->getCity($citys);
        $cates = $this->getRecommendCates();

        $viewData = [
            'city' => $this->city,
            'citys' => $citys,
            'user' => $this->user,
            'cates' => $cates
        ];
        $this->assign($viewData);
    }

    public function getCity($citys)
    {
        foreach($citys as $city){
            $city = $city->toArray();
            if($city['is_default'] == 1){
                $defaultuname = $city['uname'];
                break;
            }
        }
        $defaultuname = $defaultuname?$defaultuname:'beijing';
        if(session('cityuname','','o2o') && !input('get.city')){
            $cityuname = session('cityuname','','o2o');
        }else{
            $cityuname = input('get.city',$defaultuname,'trim');
            session('cityuname',$cityuname,'o2o');
        }
        $this->city = model('City')->where(['uname'=>$cityuname])->find();
    }

    public function getLoginUser()
    {
        if(!$this->user){
            $this->user = session('o2o_user','','o2o');
        }

        return $this->user;
    }

    /**
     * 获取首页推荐当中中的商品分类数据
     */
    public function getRecommendCates()
    {
        $parentIds = $sedCatArr = $recomCats = [];
        $cats = model('Category')->getNormalRecommendCategoryByParentId(0,5);
        foreach ($cats as $cat){
            $parentIds[] = $cat->id;
        }
        //获取二级分类数据
        $sedCats = model('Category')->getNormalCategoryIdParentId($parentIds);
        foreach ($sedCats as $sedcat){
            $sedCatArr[$sedcat->parent_id][] = [
                'id' => $sedcat->id,
                'name' => $sedcat->name
            ];
        }

        foreach ($cats as $cat) {
            //recomCats 代表的是一级 和 二级的数据 []第一个参数是一级分类的name,第二个参数是此一级分类下的所有二级分类数据
            $recomCats[$cat->id] = [
                $cat->name,empty($sedCatArr[$cat->id])?[]:$sedCatArr[$cat->id]
            ];
        }
        return $recomCats;
    }
}
