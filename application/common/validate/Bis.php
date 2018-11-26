<?php
/**
 * Created by PhpStorm.
 * User: KR
 * Date: 2018/11/20
 * Time: 13:18
 */

namespace app\common\validate;


use think\Validate;

class Bis extends Validate
{
    protected $rule = [
        'name|商户名称' => 'require|max:25',
        'email|邮箱' => 'require|email',
        'logo' => 'require',
        'city_id|城市' => 'require',
        'desc|商户介绍' => 'require',
        'bank_info|银行帐号' => 'require',
        'bank_name|开户银行' => 'require',
        'bank_user|开户姓名' => 'require',
        'faren|法人' => 'require',
        'faren_tel|法人电话' => 'require',
        'status|状态' => 'require'
    ];

    protected $scene = [
        'add' => ['name','email','logo','city_id','desc','bank_info','bank_name','bank_user','faren','faren_tel'],
        'status' => ['status']
    ];
}