<?php
/**
 * Created by PhpStorm.
 * User: KR
 * Date: 2018/11/19
 * Time: 13:13
 */

namespace app\common\validate;


use think\Validate;

class Area extends Validate
{
    protected $rule = [
        'name|商圈名' => 'require',
        'parent_id|商圈分类' => 'require',
        'pre|省份' => 'require',
        'city_id|城市' =>'require',
    ];

    protected $scene = [
        'save' => ['name','parent_id','pre','city_id'],
        'change_pre' => ['pre'],
        'up' => ['id','name','parent_id','pre','city_id'],
        'status' => ['id','status']
    ];
}