<?php

namespace app\admin\controller;

use think\Controller;

class Login extends Controller
{
    //登录
    public function login()
    {
        if(request()->isAjax()){
            $data = input('post.');
            $validate = new \app\common\validate\User();
            if(!$validate->scene('adminlogin')->check($data)){
                $this->error($validate->getError());
            }
            $result = model('User')->adminLogin($data);
            if($result == 1){
                $this->success('登录成功','admin/index/index');
            }else{
                $this->error($result);
            }
        }
        $user = session('admin_user','','admin');
        if($user && $user->id){
            $this->redirect('admin/index/index');
        }
        return view();
    }


    //退出
    public function logout()
    {
        session(null,'admin');
        $this->redirect('admin/login/login');
    }
}
