<?php
/**
 * 公共的model层
 */
namespace app\common\model;

use think\Model;

class BaseModel extends Model
{
    //添加
    public function add($data)
    {
        $data['status'] = 0;
        $this->allowField(true)->save($data);
        return $this->id;
    }
}
