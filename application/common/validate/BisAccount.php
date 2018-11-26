<?php
/**
 * Created by PhpStorm.
 * User: KR
 * Date: 2018/11/20
 * Time: 15:38
 */

namespace app\common\validate;


use think\Validate;

class BisAccount extends Validate
{
    protected $rule = [
        'username|用户名' => 'require',
        'password|密码' => 'require',
    ];

    protected $scene = [
        'add' => ['username','password'],
        'login' => ['username','password']
    ];

}