<?php

namespace app\common\model;

use think\Model;

class Area extends Model
{
    public function city()
    {
        return $this->belongsTo('City','city_id','id');
    }

    public function add($data)
    {
        $data['status'] = 1;
        return $this->allowField(true)->save($data);
    }

    public function update_data($data)
    {
        $area = $this->find($data['id']);
        return $area->allowField(true)->save($data);
    }

    //add、edit获取一级类目
    public function getNormalFirstArea()
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

    //获取一级类目
    public function getFirstAreas($parentId)
    {
        $data = [
            'parent_id' => $parentId,
            'status' => ['neq',-1]
        ];

        $order = [
            'listorder' => 'desc',
            'id' => 'desc'
        ];

        return $this->with('City')->where($data)->order($order)->paginate(10);
    }
}
