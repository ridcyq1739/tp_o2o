<?php

namespace app\api\controller;

use think\Controller;

class City extends Controller
{
    //二级城市
    public function getCitysByParentId()
    {
    	$id = input('id');
    	if(!$id){
    		$this->error('id不合法');
    	}
    	// 通过id获取二级城市
    	$citys = model('City')->getFirstCitys($id);
    	if(!$citys){
    		$this->error('错误');
    	}
    	return show(1,'success',$citys);
    }
}
