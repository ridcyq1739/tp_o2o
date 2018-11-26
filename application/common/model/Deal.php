<?php

namespace app\common\model;

use think\Model;

class Deal extends BaseModel
{
    public function city()
    {
        return $this->belongsTo('City','se_city_id','id');
    }

    public function category()
    {
        return $this->belongsTo('Category','category_id','id');
    }

    //搜索
    public function getNormalDeals($sdata = [])
    {
        $sdata['status'] = 1;
        $order = ['id'=>'desc'];
        $result = $this->with('category','city')->where($sdata)->order($order)->paginate(10);
        return $result;
    }

    /**
     * 根据分类城市来获取商品数据
     * @param $id 分类
     * @param $cityId 城市
     * @param int $limit 条数
     */
    public function getNormalDealByCategoryCityId($id,$cityId,$limit = 10)
    {
        $data = [
            'end_time' => ['gt',time()],
            'category_id' => $id,
            'city_id' => $cityId,
            'status' => 1
        ];

        $order = [
            'listorder' => 'desc',
            'id' => 'desc',
        ];

        $result = $this->where($data)->order($order);
        if($limit){
            $result = $result->limit($limit);
        }
        return $result->select();
    }

    public function getDealByCondition($data = [],$orders){
        if(!empty($orders['order_sales'])){
            $order['buy_count'] = 'desc';
        }
        if(!empty($orders['order_price'])){
            $order['current_price'] = 'desc';
        }
        if(!empty($orders['order_time'])){
            $order['create_time'] = 'dasc';
        }
        //find_in_set(11,'se_category_id');

        $order['id'] = 'desc';
        $datas[] = "end_time>".time();
        if(!empty($data['se_category_id'])){
            $datas[] = "find_in_set(".$data['se_category_id'].",se_category_id)";
        }
        if(!empty($data['category_id'])){
            $datas[] = "category_id = ".$data['category_id'];
        }
        if(!empty($data['city_id'])){
            $datas[] = "city_id = ".$data['city_id'];
        }
        $datas[] = 'status=1';
        $result = $this->where(implode(' AND ',$datas))->order($order)->paginate(10);
        return $result;
    }
}
