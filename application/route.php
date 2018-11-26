<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;
//return [
//    '__pattern__' => [
//        'name' => '\w+',
//    ],
//    '[hello]'     => [
//        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
//        ':name' => ['index/hello', ['method' => 'post']],
//    ],
//];

Route::rule('/','index/index/index','get|post');
Route::rule('login','index/user/login','get|post');
Route::rule('register','index/user/register','get|post');
Route::rule('logout','index/user/logout','get|post');
Route::rule('list/[:id]','index/lists/index','get|post');
Route::rule('detail/[:id]','index/detail/index','get|post');
Route::rule('order','index/order/index','get|post');