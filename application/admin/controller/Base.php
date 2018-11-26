<?php
/**
 * Created by PhpStorm.
 * User: KR
 * Date: 2018/11/22
 * Time: 15:02
 */

namespace app\admin\controller;


use think\Controller;

class Base extends Controller
{
    public $admin;

    public function _initialize()
    {
        //判定用户是否登录
        $isadmin = session('admin_user','','admin');
        $isLogin = $this->isLogin();
        if(!$isadmin){
            return $this->redirect('admin/login/login');
        }
    }

    //判定是否登录
    public function isLogin()
    {
        // 获取session值
        $user = $this->getLoginUser();
        if($user && $user->id){
            return true;
        }
        return false;
    }

    public function getLoginUser()
    {
        if(!$this->admin){
            $this->admin = session('adminLogin','','admin');
        }

        return $this->admin;
    }
}