<?php
/**
 * Created by PhpStorm.
 * User: KR
 * Date: 2018/11/18
 * Time: 14:30
 */

namespace app\common\validate;


use think\Validate;

class Category extends Validate
{
    protected $rule = [
        'name|分类名' => 'require|max:10',
        'parent_id|上级分类' => 'number',
        'id' => 'number',
        'status|状态' => 'number|in:-1,0,1',
        'listorder|排序' => 'number'
    ];

    protected $scene = [
        'add' => ['name','parent_id'],
        'edit' => ['name','parent_id','id'],
        'status' => ['id','status']
    ];

}