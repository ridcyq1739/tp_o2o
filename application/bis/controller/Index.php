<?php

namespace app\bis\controller;

use think\Controller;

class Index extends Base
{
    //首页
    public function index()
    {
        return view();
    }

    //退出
    public function logout()
    {
        session(null,'bis');
        $this->redirect('bis/login/index');
    }
}
