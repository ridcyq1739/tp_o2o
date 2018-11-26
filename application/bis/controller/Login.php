<?php

namespace app\bis\controller;

use think\Controller;

class Login extends Controller
{
    //登陆
    public function index()
    {
        $account = session('bisAccount','','bis');
        if ($account && $account->id){
            return $this->redirect('bis/index/index');
        }
        return view();
    }

    //登录操作
    public function login()
    {
        if (request()->isAjax()){
            $data = [
                'username' => input('username'),
                'password' => input('password')
            ];
            $validate = new \app\common\validate\BisAccount();
            if(!$validate->scene('login')->check($data)){
                $this->error($validate->getError());
            }
            $result = model('BisAccount')->login($data);
            if($result == 1){
                $this->success('用户登录成功','bis/index/index');
            }else{
                $this->error($result);
            }
        }
    }
}
