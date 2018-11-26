<?php
/**
 * Created by PhpStorm.
 * User: KR
 * Date: 2018/11/22
 * Time: 14:19
 */

namespace app\common\validate;


use think\Validate;

class Featured extends Validate
{
    protected $rule = [
        'title|标题' => 'require',
        'image|图片' => 'require',
        'type|类型' => 'require',
        'url|地址' => 'require',
        'description|描述' => 'require'
    ];

    protected $scene = [
        'add' => ['title','image','type','url','description']
    ];
}