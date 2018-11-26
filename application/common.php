<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

use phpmailer\PHPMailer;
use phpmailer\phpmailerException;
//发送邮件
function sendMail($to,$title,$content)
{
    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {
        //Server settings
        $mail->SMTPDebug = 0;                                 // Enable verbose debug output
        $mail->CharSet = 'utf-8';
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.163.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'kreg1739@163.com';                 // SMTP username
        $mail->Password = 'kreg1739';                           // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('kreg1739@163.com', 'kreg');
        $mail->addAddress($to);

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $title;
        $mail->Body    = $content;

        return $mail->send();
        echo 'Message has been sent';
    } catch (phpmailerException $e) {
        exception($mail->ErrorInfo,1001);
    }
}

// 应用公共文件
function status($status)
{
    if($status == 1){
        $str = "<span class='label label-success radius'>正常</span>";
    }elseif($status == 0){
        $str = "<span class='label label-danger radius'>待审</span>";
    }elseif($status == 2){
        $str = "<span class='label label-danger radius'>不通过</span>";
    }else{
        $str = "<span class='label label-danger radius'>删除</span>";
    }
    return $str;
}

/**
 * @param $url
 * @param int $type 0 get 1 post
 * @param array $data*
 */
function doCurl($url,$type=0,$data=[])
{
    $ch = curl_init(); //初始化
    // 设置选项
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_HEADER,0);

    if($type == 1) {
        //post
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFILEDS,$data);
    }

    //执行并获取内容
    $output = curl_exec($ch);
    //释放curl句柄
    curl_close($ch);
    return $output;
}

//商户入驻申请文案
function bisRegister($status){
    if($status == 1){
        $str = '入驻申请成功';
    }elseif($status == 0){
        $str = '待审核，审核成功后平台方会发送邮件通知，请关注邮件';
    }elseif($status == 2){
        $str = '非常抱歉，您提交的材料不符合条件，请重新提交';
    }else{
        $str = '该申请已被删除';
    }
    return $str;
}

/**
 * @param $obj
 * 分页样式
 */
function pagination($obj){
    if(!$obj){
        return '';
    }
    //优化
    $params = request()->param();
    return '<div class="cl pd-5 bg-1 bk-gray mt-20 tp5-o2o">'.$obj->appends($params)->render().'</div>';
}

//获取指定商户二级城市
function getSeCityName($path) {
    if(empty($path)) {
        return '';
    }
    if(preg_match('/,/', $path)) {
        $cityPath = explode(',', $path);
        $cityId = $cityPath[1];
    }else {
        $cityId = $path;
    }
    $city = model('City')->get($cityId);
    return $city->name;
}
//分店
function getSeFdName($path) {
    $str = '';
    if(empty($path)) {
        return '';
    }
    if(preg_match('/,/', $path)) {
        $fds = explode(',', $path);
        foreach($fds as $value){
            $fd = model('BisLocation')->find($value);
            $a = $fd['name'];
            $str .= $a.'  ';
        }
    }else {
        $fd = $path;
        $str .= $fd;
    }

    return $str;
}

//获取指定商户二级分类
function getSeCategoryName($path) {
    if(empty($path)) {
        return '';
    }

    if(preg_match('/,/', $path)) {
        $categoryPath = explode(',', $path);
        $categoryId = $categoryPath[1];
    }else {
        $cityId = $path;
    }
    if($categoryId){
        if(preg_match('/|/', $categoryId)){
            $categorys = explode('|',$categoryId);
        }
    }else{
        return '';
    }
    $str = '';
    if($categorys){
        foreach($categorys as $value){
            $cate = model('Category')->find($value);
            $a = $cate->name;
            $str .= $a.'  ';
        }
        return $str;
    }else{
        return '';
    }

}

//是否为总店
function main($is_main){
    if($is_main==1){
        return '是';
    }else{
        return '否';
    }
}

function countLocation($ids)
{


    if(preg_match('/,/',$ids)){
        $arr = explode(',',$ids);
        return count($arr);
    }else{
        return 1;
    }


}

//生成订单号
function setOrderSn(){
    list($t1,$t2) = explode(' ',microtime());
    $t3 = explode('.',$t1*10000);
    return $t2.$t3[0].(rand(10000,99999));

}

//后台用户状态
function admin_status($data) {
    if($data == 1){
        $str = "<span class='label label-success radius'>已启用</span>";
    }elseif($data == 0){
        $str = "<span class='label label-defaunt radius'>已停用</span>";
    }else{
        $str = "<span class='label label-danger radius'>删除</span>";
    }
    return $str;
}

function pay_status($status)
{
    if($status == 1){
        $str = "<span class='label label-success radius'>已支付</span>";
    }elseif($status == 0){
        $str = "<span class='label label-defaunt radius'>未支付</span>";
    }
    return $str;
}