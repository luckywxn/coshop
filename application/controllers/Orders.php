<?php

/**
 * Created by PhpStorm.
 * User: 129
 * Date: 2017/8/25
 * Time: 16:18
 */
class OrdersController extends Yaf_Controller_Abstract
{
    /**
     * GoodsController::init()
     */
    public function init() {
        # parent::init();
    }

    /**
     * 商品列表
     */
    public function listAction(){
        $params['user']  = Yaf_Registry::get(SSN_VAR);
        if(!$params['user']){
            echo "<script>alert(\"请先登录\");</script>";
            $this->getView()->make('index.login', array());
        }
        $search = array(
            'member_no' => $params['user']['member_no'],
            'page' => false,
        );

        $order = new OrdersModel(Yaf_Registry::get("db"),Yaf_Registry::get('mc'));
        $list =  $order->searchOrders($search);
//        echo "<pre>";
//        var_dump($list['list']);
//        exit;
        $params['orders'] = $list['list'];
        $this->getView()->make('orders.list',$params);
    }

    /**
     * 商品列表数据
     */
    public function listJsonAction(){
        $request = $this->getRequest();
        $search = array(
            'companyname' => $request->getPost('companyname',''),
            'goodsno' => $request->getPost('goodsno',''),
            'goodsname' => $request->getPost('goodsname',''),
            'pageSize' => COMMON::PR(),
            'pageCurrent' => COMMON::P(),
        );

        $Orders = new OrdersModel(Yaf_Registry::get("db"),Yaf_Registry::get('mc'));
        $list =  $Orders->searchOrders($search);
        echo json_encode($list);
    }

    /**
     * 从购物车结算打开下单页面
     */
    public function jiesuanAction(){
        $request = $this->getRequest();
        $datastr = $request->getParam('strolley','');
//        $var = explode(",",$datastr);
        $Shoppingtrolley = new ShoppingtrolleyModel(Yaf_Registry::get("db"),Yaf_Registry::get('mc'));
        $trolleys =  $Shoppingtrolley->getGoodsDetailByIds($datastr);
        $params['trolleys'] = $trolleys;
        foreach ($trolleys as $key=>$val){
            $params['totalprice'] += $val['totalprice'];
        }

        $this->getView()->make('orders.order',$params);
    }

    /**
     * 下单
     */
    public function neworderAction(){


//        header("Location:http://alipay.strongculture.cn/");
    }


}