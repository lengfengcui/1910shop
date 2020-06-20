<?php

namespace App\Http\Controllers\Goods;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\GoodsModel;

class GoodsController extends Controller
{
    //商品详情
    public function detail(){
        $goods_id=$_GET['id'];
        echo 'goods_id:'.$goods_id;echo '</br>';

        //查询商品详情
        //$info=GoodsModel::where(['goods_id'=>$goods_id])->get()->toArray();
        $info=GoodsModel::find($goods_id);//find查找主键
        echo '<pre>';print_r($info);echo '</pre>';
    }
   
}
