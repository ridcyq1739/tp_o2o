<?php
/**
 * Created by PhpStorm.
 * User: KR
 * Date: 2018/11/18
 * Time: 23:15
 */

namespace app\common\validate;


use think\Validate;

//城市
class City extends Validate
{
    protected $rule = [
        'name|城市中文名' => 'require',
        'uname|城市英文名' => 'require',
        'parent_id|父id' => 'require',
        'id' => 'require'
    ];

    protected $scene = [
        'add' => ['name','uname','parent_id'],
        'edit' => ['name','uname','parent_id','id'],
        'status' => ['status','id']
    ];
}