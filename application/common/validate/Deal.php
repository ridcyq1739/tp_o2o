<?php
/**
 * Created by PhpStorm.
 * User: KR
 * Date: 2018/11/21
 * Time: 21:12
 */

namespace app\common\validate;


use think\Validate;

class Deal extends Validate
{
    protected $rule = [
        'name|团购名称' => 'require',
        'city_id|城市' => 'require',
        'se_city_id|市区' => 'require',
        'category_id|分类' => 'require',
        'location_ids|门店' => 'require',
        'image|图片' => 'require',
        'start_time|团购开始时间' => 'require',
        'end_time|团购结束时间' => 'require',
        'total_count|库存数' => 'require',
        'origin_price|原价' => 'require',
        'current_price|现价' => 'require',
        'coupons_begin_time|消费卷生效时间' => 'require',
        'coupons_end_time|消费卷结束时间' => 'require',
        'desc|团购描述' => 'require',
        'notes|购买须知' => 'require',
    ];

    protected $scene =[
      'add' => ['name','city_id','se_city_id','category_id','location_ids','image','start_time','end_time','toatl_count','origin_price'
          ,'current_price','coupons_begin_time','coupons_end_time','desc','notes']
    ];
}