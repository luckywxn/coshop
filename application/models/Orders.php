<?php

/**
 * Created by PhpStorm.
 * User: 129
 * Date: 2017/8/25
 * Time: 16:25
 */
class OrdersModel
{
    /**
     * 数据库类实例
     */
    public $dbh = null;
    public $mch = null;

    /**
     * Constructor
     */
    public function __construct($dbh, $mch = null)
    {
        $this->dbh = $dbh;
        $this->mch = $mch;
    }

    public function searchOrders($params){
        $filter = array();
        if (isset($params['sysno']) && $params['sysno'] != '') {
            $filter[] = " cu.`sysno` = ".$params['sysno']." ";
        }
        $where =" WHERE co.`isdel` = 0 ";
        if (1 <= count($filter)) {
            $where .= "AND ". implode(' AND ', $filter);
        }
        $orders = " ORDER BY co.created_at DESC";

        $sql = "SELECT count(co.`sysno`) FROM `concap_orders` co
                LEFT JOIN concap_user cu ON cu.sysno = co.user_sysno $where";
        $totalRow = $this->dbh->select($sql);
        $result['totalRow'] = count($totalRow);
        if($result['totalRow']){
            if(isset($params['page'])&&$params['page'] == false){
                $sql = "SELECT co.sysno,co.ordersno,co.logisticsno,co.orderstatus,cua.phone,cua.address,sum(cg.price*cod.number) totalprice,co.created_at,co.paytime_at,co.sendtime_at,cu.nickname
                        FROM `concap_orders` co
                        LEFT JOIN concap_user cu ON cu.sysno = co.user_sysno
                        LEFT JOIN concap_orders_detail cod ON cod.orders_sysno = co.sysno
                        LEFT JOIN concap_goods cg ON cg.sysno = cod.goods_sysno
                        LEFT JOIN concap_user_address cua ON cua.sysno = co.address_sysno
                        $where GROUP BY co.sysno $orders";
                $result['list'] = $this->dbh->select($sql);
            }else{
                $result['totalPage'] = ceil($result['totalRow'] / $params['pageSize']);
                $this->dbh->set_page_num($params['pageCurrent']);
                $this->dbh->set_page_rows($params['pageSize']);
                $sql = "SELECT co.sysno,co.ordersno,co.logisticsno,co.orderstatus,cua.phone,cua.address,sum(cg.price*cod.number) totalprice,co.created_at,co.paytime_at,co.sendtime_at,cu.nickname
                        FROM `concap_orders` co
                        LEFT JOIN concap_user cu ON cu.sysno = co.user_sysno
                        LEFT JOIN concap_orders_detail cod ON cod.orders_sysno = co.sysno
                        LEFT JOIN concap_goods cg ON cg.sysno = cod.goods_sysno
                        LEFT JOIN concap_user_address cua ON cua.sysno = co.address_sysno
                        $where GROUP BY co.sysno $orders";
                $result['list'] = $this->dbh->select_page($sql);
            }

            $sql = "SELECT cod.orders_sysno,cod.number,cg.goodsno,cg.goodsname,cg.price,cc.companyname,cga.path,cga.name
                        FROM `concap_orders_detail` cod
                        LEFT JOIN concap_goods cg ON cg.sysno = cod.goods_sysno
                        LEFT JOIN concap_company cc ON cc.sysno = cg.company_sysno
                        LEFT JOIN concap_goods_attach cga ON cga.goods_sysno = cg.sysno ";
            $detail = $this->dbh->select($sql);
            if(!empty($result['list'])){
                foreach($result['list'] as $key => $item){
                    $result['list'][$key]['created_at'] = date('Y-m-d',strtotime($item['created_at'])) ;
                    if($item['orderstatus'] == 1){
                        $result['list'][$key]['orderstatus'] = '待付款' ;
                    }elseif($item['orderstatus'] == 2){
                        $result['list'][$key]['orderstatus'] = '已付款' ;
                    }elseif($item['orderstatus'] == 3){
                        $result['list'][$key]['orderstatus'] = '待发货' ;
                    }elseif($item['orderstatus'] == 4){
                        $result['list'][$key]['orderstatus'] = '运输中' ;
                    }elseif($item['orderstatus'] == 5){
                        $result['list'][$key]['orderstatus'] = '已收货' ;
                    }
                    foreach($detail as $value){
                        if($item['sysno'] == $value['orders_sysno']){
                            $result['list'][$key]['detail'][] = $value ;
                        }
                    }
                }
            }
        }
        return $result;
    }

}