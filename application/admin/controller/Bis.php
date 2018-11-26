<?php

namespace app\admin\controller;

use think\Controller;

class Bis extends Base
{
    //index
    public function index()
    {
        $biss = model('Bis')->getBisByStatus(1);
        $viewData = [
            'biss' => $biss,
        ];
        $this->assign($viewData);
        return view();
    }
    //入驻申请
    public function apply()
    {
        $biss = model('Bis')->getBisByStatus();
        $viewData = [
            'biss' => $biss,
        ];
        $this->assign($viewData);
        return view();
    }
    //删除列表
    public function dellist()
    {
        $biss = model('Bis')->getBisByStatus(2);
        $viewData = [
            'biss' => $biss,
        ];
        $this->assign($viewData);
        return view();
    }
    //分店信息
    public function fdlist()
    {
        $locations = model('BisLocation')->where(['status'=>['neq',-1],'is_main'=>0])->paginate(10);
        $viewData = [
            'locations' => $locations,
        ];
        $this->assign($viewData);
        return view();
    }

    //状态修改
    public function status()
    {
        if(request()->isAjax()){
            $data = [
                'id' => input('id'),
                'status' => input('status'),
            ];
            $validate =  new \app\common\validate\Bis();
            if(!$validate->scene('status')->check($data)){
                $this->error($validate->getError());
            }
            if($data['status'] == 0){
                $data['status'] = 1;
            }
            $bis = model('Bis')->find($data['id']);
            $bis->status = $data['status'];
            $result = $bis->save();
            $location = model('BisLocation')->save(['status'=>$data['status']],['bis_id'=>$data['id'],'is_main'=>1]);
            $account = model('BisAccount')->save(['status'=>$data['status']],['bis_id'=>$data['id'],'is_main'=>1]);
            if($result && $location && $account){
                $title = 'o2o入驻申请通知';
                $content = '您的入驻申请通过了！';
                if($bis['status']==2){
                    $content = '您的入驻申请失败了！';
                }
                $result = sendMail($bis['email'],$title,$content);
                $this->success('状态更新成功');
            }else{
                $title = 'o2o入驻申请通知';
                $content = '您的入驻申请失败了！';
                $result = sendMail($bis['email'],$title,$content);
                $this->error('状态更新失败');
            }
        }
    }
    //分店入驻审批
    public function fdstatus()
    {
        if(request()->isAjax()){
            $data = [
                'id' => input('id'),
                'status' => input('status') == 0?1:0,
            ];
            $fd = model('BisLocation')->find($data['id']);
            $fd->status = $data['status'];
            $result = $fd->save();
            if($result) {
                $this->success('操作成功');
            }else{
                $this->error('操作失败');
            }
        }
    }

    //申请信息
    public function detail() {
        $id = input('get.id');
        if(empty($id)) {
            return $this->error('ID错误');
        }
        //获取一级城市的数据
        $citys = model('City')->getNormalFirstCity();
        //获取一级栏目的数据
        $categorys = model('Category')->getNormalFirstCategory();
        // 获取商户数据
        $bisData = model('Bis')->get($id);
        $locationData = model('BisLocation')->get(['bis_id'=>$id, 'is_main'=>1]);
        $accountData = model('BisAccount')->get(['bis_id'=>$id, 'is_main'=>1]);
        return $this->fetch('',[
            'citys' => $citys,
            'categorys' => $categorys,
            'bisData' => $bisData,
            'locationData' => $locationData,
            'accountData' => $accountData,
        ]);
    }
    //分店申请信息
    public function fddetail()
    {
        $id = input('get.id');
        if(empty($id)) {
            return $this->error('ID错误');
        }
        //获取一级城市的数据
        $citys = model('City')->getNormalFirstCity();
        //获取一级栏目的数据
        $categorys = model('Category')->getNormalFirstCategory();
        // 获取商户数据
        $locationData = model('BisLocation')->find($id);
        return $this->fetch('',[
            'citys' => $citys,
            'categorys' => $categorys,
            'locationData' => $locationData,
        ]);
    }

    //删除stauts=-1
    public function del()
    {
        if(request()->isAjax()){
            $data = [
                'id' => input('id')
            ];
            $bis = model('Bis')->find($data['id']);
            $bis->status = -1;
            $result = $bis->save();
            $location = model('BisLocation')->save(['status'=>-1],['bis_id'=>$data['id'],'is_main'=>1]);
            $account = model('BisAccount')->save(['status'=>-1],['bis_id'=>$data['id'],'is_main'=>1]);
            if($result){
                $this->success('删除成功');
            }else{
                $this->error('删除失败');
            }
        }
    }

    //删除分店操作
    public function delfd()
    {
        $id = input('id');
        $location = model('BisLocation')->find($id);
        $location->status = -1;
        $result = $location->save();
        if($result){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }
}
