<?php

namespace app\api\controller;

use think\Controller;
use think\Request;
use think\File;
class Image extends Controller
{
    public function upload()
    {
        $file = Request::instance()->file('file');
        // 上传目录
        $info = $file->move('upload');// 生成public/upload

        if($info && $info->getPathname())
        {
            return show('1', 'success','/'.$info->getPathname());
        }
        return show('0', '上传图片失败');
    }
}
