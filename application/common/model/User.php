<?php

namespace app\common\model;

use think\Model;

class User extends Model
{
    //注册
    public function register($data = []){

        $data['code'] = mt_rand(100,10000);
        $data['password'] = md5($data['password'].$data['code']);
        $data['status'] = 0;
        $this->allowField(true)->save($data);
        return 1;
    }

    //登录
    public function login($data = []){
        $user = $this->get(['username'=>$data['username']]);
        if(!$user || $user->status != 1){
            return '用户不存在，或者用户没有权限登录。';
        }
        if ($user->password != md5($data['password'].$user->code)){
            return "密码错误";
        }
        $this->allowField(true)->save(['last_login_time'=>time()],['id'=>$user->id]);
        session('o2o_user',$user,'o2o');
        return $user->id;
    }

    //后台登录
    public function adminLogin($data = []){
        $user = $this->get(['username'=>$data['username']]);
        if(!$user || $user->status != 1 || $user->is_super !=1){
            return '用户不存在，或者用户没有权限登录。';
        }
        if ($user->password != md5($data['password'].$user->code)){
            return "密码错误";
        }
        $this->allowField(true)->save(['last_login_time'=>time()],['id'=>$user->id]);
        session('admin_user',$user,'admin');
        return $user->id;
    }

    //搜索用户
    public function getNormalUsers($sdata = []){
        $sdata['status'] = ['neq',-1];
        $order = ['id'=>'desc'];
        $result = $this->where($sdata)->order($order)->paginate(10);
        return $result;
    }
}
