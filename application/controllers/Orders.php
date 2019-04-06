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
        $datastr = $request->getPost('data','');
        $params['datastr'] = $datastr;
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
        $request = $this->getRequest();
        $datastr = $request->getPost('data','');
        $Orders = new OrdersModel(Yaf_Registry::get("db"),Yaf_Registry::get('mc'));
        $res = $Orders->addOrder($datastr);
        $data = array(
            "WIDout_trade_no"=>$res["order_no"],
            "WIDsubject"=>$res["order_no"],
            "WIDtotal_amount"=>$res["total_price"],
            "WIDbody"=>"",
        );
        $url = "http://alipay.strongculture.cn/pagepay/pagepay.php";
        $res = $this->http_request($url, $data);
        var_dump($res);
    }

    /**
     * 支付订单
     */
    public function payorderAction(){
        $request = $this->getRequest();
        $data = $request ->getPost();
        $url = "http://alipay.strongculture.cn/pagepay/pagepay.php";
        $res = $this->http_request($url, $data);
        var_dump($res);
    }

    //HTTP请求（支持HTTP/HTTPS，支持GET/POST）
    function http_request($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);//设置header
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $output = curl_exec($curl);

        curl_close($curl);
        return $output;
    }

    /**
     * 支付成功回调地址
     */
    public function payreturnAction(){
        $request = $this->getRequest();
        $order_no = $request ->getParam("out_trade_no","");
        $trade_no = $request ->getParam("trade_no","");
        if($order_no&&$trade_no){
            $data = array(
                "pay_no"=>$trade_no,
                "paytime_at"=>"=NOW()",
                "order_status"=>2,//已付款
                "updated_at"=>"=NOW()",
            );
            $Orders = new OrdersModel(Yaf_Registry::get("db"),Yaf_Registry::get('mc'));
            $res = $Orders->updateOrder($order_no,$data);
            if($res){
                header("Location: http://coshop.strongculture.cn/orders/list");
            }else{
                echo "更新订单失败";
            }
        }else{
            echo "请求失败";
        }
    }


}