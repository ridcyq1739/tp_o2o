<?php
/**
 * Created by PhpStorm.
 * User: KR
 * Date: 2018/11/22
 * Time: 18:27
 */

namespace app\common\validate;


use think\Validate;

class User extends Validate
{
    protected $rule = [
        'username|用户名' => 'require',
        'password|密码' => 'require',
        'conpass|确认密码' => 'require|confirm:password',
        'email|邮箱' => 'require|email|unique:user',
        'verify|验证码' => 'require|captcha'
    ];

    protected $scene = [
        'register' => ['username','password','conpass','email','verify'],
        'login' => ['username','password'],
        'adminlogin' => ['username','password']
    ];

}