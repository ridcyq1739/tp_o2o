<?php

namespace app\index\controller;

use think\Controller;

class User extends Controller
{
    //登录
    public function login()
    {
        if(request()->isAjax()){
            $data = input('post.');
            $validate = new \app\common\validate\User();
            if(!$validate->scene('login')->check($data)){
                $this->error($validate->getError());
            }
            $result = model('User')->adminLogin($data);
            if($result == 1){
                $this->success('登录成功','index/index/index');
            }else{
                $this->error($result);
            }
        }
        $user = session('o2o_user','','o2o');
        if($user && $user->id){
            $this->redirect('index/index/index');
        }
        return view();
    }

    //注册
    public function register()
    {
        if(request()->isAjax()){
            $data = input('post.');
            $validate = new \app\common\validate\User();
            if(!$validate->scene('register')->check($data)){
                $this->error($validate->getError());
            }
            $res = model('User')->where(['username'=>$data['username']])->select();
            if($res){
                $this->error('用户名已存在');
            }
            $result = model('User')->register($data);
            if($result){
                $this->success('注册成功','index/user/login');
            }else {
                $this->error('注册失败');
            }
        }
        return view();
    }

    //退出
    public function logout()
    {
        session(null,'o2o');
        $this->redirect('index/user/login');
    }
}
