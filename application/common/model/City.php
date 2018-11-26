<?php

namespace app\common\model;

use think\Model;

//城市
class City extends Model
{
    public function deal()
    {
        return $this->hasMany('Deal','city_id',id);
    }

    public function area()
    {
        return $this->hasMany('Area','city_id','id');
    }

    //添加城市
    public function add($data)
    {
        $data['status'] = 1;
        return $this->save($data);
    }

    //编辑城市
    public function edit($data)
    {
        $cityInfo = $this->find($data['id']);
        $result = $cityInfo->allowField(true)->save($data);
        return $result;
    }

    //add、edit获取一级省市
    public function getNormalFirstCity()
    {
        $data = [
            'status' => 1,
            'parent_id' => 0,
        ];

        $order = [
            'id' => 'desc',
        ];

        return $this->where($data)->order($order)->select();
    }

    //获取一级省市
    public function getFirstCitys($parentId)
    {
        $data = [
            'parent_id' => $parentId,
            'status' => ['neq',-1]
        ];

        $order = [
            'listorder' => 'desc',
            'id' => 'desc'
        ];

        return $this->where($data)->order($order)->paginate(10);
    }

    //获取市级城市
    public function getNormalCitys()
    {
        $data = [
            'status' => 1,
            'parent_id' => ['gt',0]
        ];
        $order  = [
            'id' => 'desc'
        ];
        return $this->where($data)->order($order)->select();
    }
}
