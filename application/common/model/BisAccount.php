<?php

namespace app\common\model;

use think\Model;

class BisAccount extends BaseModel
{
    //登录
    public function login($data)
    {
        $account = $this->get(['username'=>$data['username']]);
        if(!$account || $account->status != 1){
            return '用户不存在，或者用户没有权限登录。';
        }
        if ($account->password != md5($data['password'].$account->code)){
            return "密码错误";
        }
        $this->allowField(true)->save(['last_login_time'=>time()],['id'=>$account->id]);
        session('bisAccount',$account,'bis');
        return 1;
    }
}
