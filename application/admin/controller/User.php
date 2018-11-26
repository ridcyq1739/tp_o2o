<?php

namespace app\admin\controller;

use think\Controller;

class User extends Base
{
    public function index()
    {
        $users = model('User')->where(['status'=>['neq',-1]])->paginate(10);
        $data = input('get.');
        $sdata = [];
        if ($data){
            if(!empty($data['start_time']) && !empty($data['end_time']) && strtotime($data['end_time'])>strtotime($data['start_time'])){
                $sdata['create_time'] = [
                    ['gt',strtotime($data['start_time'])],
                    ['lt',strtotime($data['end_time'])]
                ];
            }
            if(!empty($data['username'])){
                $sdata['username'] = ['like','%'.$data['username'].'%'];
            }
            $users = model('User')->getNormalUsers($sdata);
        }
        $viewData = [
            'users' => $users
        ];
        $this->assign($viewData);
        return view();
    }

    public function status()
    {
        if(request()->isAjax())
        {
            $id = input('id');
            $status = input('status');
            if($status==1){
                $status=0;
            }elseif($status==0){
                $status=1;
            }
            $user = model('User')->find($id);
            $user->status = $status;
            $result = $user->save();
            if($result){
                $this->success('修改成功');
            }else{
                $this->error('修改失败');
            }
        }
    }

    public function del()
    {
        if(request()->isAjax())
        {
            $id = input('id');
            $user = model('User')->find($id);
            $user->status = -1;
            $result = $user->save();
            if($result){
                $this->success('删除成功');
            }else{
                $this->error('删除失败');
            }
        }
    }
}
