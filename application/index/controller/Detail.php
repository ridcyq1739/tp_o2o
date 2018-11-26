<?php

namespace app\index\controller;

use think\Controller;

class Detail extends Base
{
    //详情
    public function index($id)
    {
        if(!intval($id)){
            $this->error('ID不合法');
        }
        // 根据id查询商品
        $deal = model('Deal')->get($id);
        $bis = model('Bis')->get($deal->bis_id);
        if(!$deal || $deal->status != 1){
            $this->error('商品不存在');
        }
        $category = model('Category')->get($deal->category_id);
        //获取分点信息
        $locations = model('BisLocation')->getNormalLocationInId($deal->location_ids);
        $flag = 0;
        $timedata = '';
        if($deal->start_time>time()){
            $flag = 1;
            $dtime = $deal->start_time-time();

            $d = floor($dtime/(3600*24));
            if($d){
                $timedata .= $d."天 ";
            }
            $h = floor($dtime%(3600*24)/3600);
            if($h){
                $timedata .= $h."小时";
            }
            $m = floor($dtime%(3600*24)%3600/60);
            if($m){
                $timedata .= $m."小分";
            }
        }
        $viewData = [
            'deal' => $deal,
            'category' => $category,
            'locations' => $locations,
            'overplus' => $deal->total_count-$deal->buy_count,
            'flag' => $flag,
            'timedata' => $timedata,
            'mapstr' => $locations[0]['xpoint'].','.$locations[0]['ypoint'],
            'bis' => $bis
        ];
        $this->assign($viewData);
        return view();
    }
}
