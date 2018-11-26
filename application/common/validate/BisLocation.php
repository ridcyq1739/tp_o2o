<?php
/**
 * Created by PhpStorm.
 * User: KR
 * Date: 2018/11/20
 * Time: 15:37
 */

namespace app\common\validate;


use think\Validate;

class BisLocation extends Validate
{
    protected $rule = [
        'contact|联系人' => 'require|max:25',
        'category_id|分类' => 'require',
        'content|门店介绍' => 'require',
        'address|地址' => 'require',
        'open_time|开始时间' => 'require',
        'tel|电话' => 'require',
        'logo' => 'require',
        'name|分店名' => 'require',
    ];

    protected $scene = [
        'add' => ['contact','category_id','content','address','open_time','tel'],
        'sq' => ['contact','logo','name','category_id','content','address','open_time','tel'],
    ];
}