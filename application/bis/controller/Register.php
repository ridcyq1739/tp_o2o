<?php

namespace app\bis\controller;



use think\Controller;

class Register extends Controller
{
    //商家申请入驻
    public function index()
    {
        $citys = model('City')->getNormalFirstCity();
        $categorys = model('Category')->getNormalFirstCategory();
        $viewData = [
            'citys' => $citys,
            'categorys' => $categorys
        ];
        $this->assign($viewData);
        return view();
    }

    public function add()
    {
        if(!request()->isAjax()){
            $this->error('请求错误');
        }
        //获取表单的值
        $data = input('post.','','htmlentities');
        //检验数据
        $validate = new \app\common\validate\Bis();
        if(!$validate->scene('add')->check($data)){
            $this->error($validate->getError());
        }

        //获取经纬度
        $lnglat = \Map::getLngLat($data['address']);
        if(empty($lnglat) || $lnglat['status'] != 0 || $lnglat['result']['precise']!=0){
            $this->error('无法获取数据，或者匹配的不精确');
        }
        // 判定提交的用户是否存在
        $accountResult = model('BisAccount')->get(['username'=>$data['username']]);
        //echo model('BisAccount')->getLastSql();exit;
        if($accountResult) {
            $this->error('该用户存在，请重新分配');
        }
        //商户基本信息入库
        $bisData = [
            'name' => $data['name'],
            'city_id' => $data['city_id'],
            'city_path' => empty($data['se_city_id'])?data['city_id']:$data['city_id'].','.$data['se_city_id'],
            'logo' => $data['logo'],
            'licence_logo' => $data['licence_logo'],
            'description' => empty($data['desc'])?'':$data['desc'],
            'bank_info' => $data['bank_info'],
            'bank_user' => $data['bank_user'],
            'bank_name' => $data['bank_name'],
            'faren' => $data['faren'],
            'faren_tel' => $data['faren_tel'],
            'email' => $data['email']
        ];
        $bisId = model('Bis')->add($bisData);
        //总店相关信息校验
        $validateLocation = new \app\common\validate\BisLocation();
        if(!$validateLocation->scene('add')->check($data)){
            $this->error($validate->getError());
        }
        $data['cat'] = '';
        if(!empty($data['se_category_id'])) {
            $data['cat'] = implode('|', $data['se_category_id']);
        }
        //总店相关信息入库
        $locationData = [
            'bis_id' => $bisId,
            'name' => $data['name'],
            'tel' => $data['tel'],
            'logo' => $data['logo'],
            'contact' => $data['contact'],
            'category_id' => $data['category_id'],
            'category_path' => $data['category_id'].','.$data['cat'],
            'city_id' => $data['city_id'],
            'city_path' => empty($data['se_city_id'])?data['city_id']:$data['city_id'].','.$data['se_city_id'],
            'address' => $data['address'],
            'api_address' => $data['address'],
            'open_time' => $data['open_time'],
            'content' => empty($data['content'])?'':$data['content'],
            'is_main' => 1,//代表总店信息
            'xpoint' => empty($lnglat['result']['location']['lng'])?'':$lnglat['result']['location']['lng'],
            'ypoint' => empty($lnglat['result']['location']['lat'])?'':$lnglat['result']['location']['lat'],
        ];
        $locationId = model('BisLocation')->add($locationData);
        $data['code'] = mt_rand(100,10000);//自动生成密码的加盐字符串
        //账户相关信息校验
        $validateAccount = new \app\common\validate\BisAccount();
        if(!$validateAccount->scene('add')->check($data)){
            $this->error($validate->getError());
        }
        //总店信息入库
        $accountData = [
            'bis_id' => $bisId,
            'username' => $data['username'],
            'code' => $data['code'],
            'password' => md5($data['password'].$data['code']),
            'is_main' => 1, //代表总管理员
        ];

        $accountId = model('BisAccount')->add($accountData);
        if(!$bisId){
            $this->error('基本信息错误,申请失败');
        }
        if(!$accountId){
            $this->error('总店信息错误,申请失败');
        }
        if(!$accountId){
            $this->error('帐号信息错误,申请失败');
        }
        //发送邮件

        $url = request()->domain().url('bis/register/waiting',['id'=>$bisId]);
        $title = 'o2o入驻申请通知';
        $content = '您提交的入驻申请需等待平台方审核，您可以通过点击链接<a href="'.$url.'" target="_blank">查看链接</a> 查看审核状态';
        $result = sendMail($data['email'],$title,$content);
        if($result){
            $this->success('申请成功,请去邮箱查看',url('bis/register/waiting',['id'=>$bisId]));
        }
    }

    public function waiting($id)
    {
        if(empty($id)){
            $this->error('error');
        }
        $detail = model('Bis')->get($id);

        $this->assign('detail',$detail);

        return view();
    }
}
