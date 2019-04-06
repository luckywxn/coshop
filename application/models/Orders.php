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

    /**
     * 查询订单
     * @param $params
     * @return mixed
     */
    public function searchOrders($params){
        $filter = array();
        if (isset($params['member_no']) && $params['member_no'] != '') {
            $filter[] = " cu.`member_no` = '{$params['member_no']}' ";
        }
        $where =" WHERE co.`ok_del` = 0 ";
        if (1 <= count($filter)) {
            $where .= "AND ". implode(' AND ', $filter);
        }
        $orders = " ORDER BY co.created_at DESC";

        $sql = "SELECT count(co.`sysno`) FROM `orders` co
                LEFT JOIN user_member cu ON cu.member_no = co.member_no $where";
        $totalRow = $this->dbh->select($sql);
        $result['totalRow'] = count($totalRow);
        if($result['totalRow']){
            if(isset($params['page'])&&$params['page'] == false){
                $sql = "SELECT co.sysno,co.order_no,co.logisticsno,co.order_status,cua.phone,cua.address,sum(cg.price*cod.number) totalprice,co.created_at,co.paytime_at,co.sendtime_at,cu.nick_name
                        FROM `orders` co
                        LEFT JOIN user_member cu ON cu.member_no = co.member_no
                        LEFT JOIN orders_detail cod ON cod.order_no = co.order_no
                        LEFT JOIN goods cg ON cg.sysno = cod.goods_sysno
                        LEFT JOIN user_member_address cua ON cua.sysno = co.address_sysno
                        $where GROUP BY co.sysno $orders";
                $result['list'] = $this->dbh->select($sql);
            }else{
                $result['totalPage'] = ceil($result['totalRow'] / $params['pageSize']);
                $this->dbh->set_page_num($params['pageCurrent']);
                $this->dbh->set_page_rows($params['pageSize']);
                $sql = "SELECT co.sysno,co.order_no,co.logisticsno,co.order_status,cua.phone,cua.address,sum(cg.price*cod.number) totalprice,co.created_at,co.paytime_at,co.sendtime_at,cu.nick_name
                        FROM `orders` co
                        LEFT JOIN user_member cu ON cu.member_no = co.member_no
                        LEFT JOIN orders_detail cod ON cod.order_no = co.order_no
                        LEFT JOIN goods cg ON cg.sysno = cod.goods_sysno
                        LEFT JOIN user_member_address cua ON cua.sysno = co.address_sysno
                        $where GROUP BY co.sysno $orders";
                $result['list'] = $this->dbh->select_page($sql);
            }

            $sql = "SELECT cod.order_no,cod.number,cg.goodsno,cg.goodsname,cg.price,cm.merchant_name,cga.path,cga.name
                        FROM `orders_detail` cod
                        LEFT JOIN goods cg ON cg.sysno = cod.goods_sysno
                        LEFT JOIN user_merchant cm ON cm.merchant_no = cg.merchant_no
                        LEFT JOIN goods_attach cga ON cga.goods_sysno = cg.sysno ";
            $detail = $this->dbh->select($sql);
            if(!empty($result['list'])){
                foreach($result['list'] as $key => $item){
                    $result['list'][$key]['created_at'] = date('Y-m-d',strtotime($item['created_at'])) ;
                    if($item['order_status'] == 1){
                        $result['list'][$key]['order_status'] = '待付款' ;
                    }elseif($item['order_status'] == 2){
                        $result['list'][$key]['order_status'] = '已付款' ;
                    }elseif($item['order_status'] == 3){
                        $result['list'][$key]['order_status'] = '待发货' ;
                    }elseif($item['order_status'] == 4){
                        $result['list'][$key]['order_status'] = '运输中' ;
                    }elseif($item['order_status'] == 5){
                        $result['list'][$key]['order_status'] = '已收货' ;
                    }
                    foreach($detail as $value){
                        if($item['order_no'] == $value['order_no']){
                            $result['list'][$key]['detail'][] = $value ;
                        }
                    }
                }
            }
        }
        return $result;
    }

    /**
     * 创建订单
     */
    public function addOrder($str){
        $user = Yaf_Registry::get(SSN_VAR);
        $this->dbh->begin();
        try{
            //将商品从购物车中移除
            $Shoppingtrolley = new ShoppingtrolleyModel(Yaf_Registry::get("db"),Yaf_Registry::get('mc'));
            $updatetrolley = array(
                'have_order' =>true,
                'ok_del' =>true,
            );
            $res = $Shoppingtrolley->updatetrolleys($str,$updatetrolley);
            if(!$res){
                $this->dbh->rollback();
                return false;
            }

            $trolleys =  $Shoppingtrolley->getGoodsDetailByIds($str);
            $totalPrice = 0;
            foreach ($trolleys as $trolley){
                $totalPrice += $trolley['totalprice'];
            }
            //生成订单
            $orderdata = array(
                'member_no'=>$user['member_no'],
                'order_no'=>COMMON::getCodeId("O"),
                'total_price'=>$totalPrice, //订单总价
                'order_status'=>1, //待付款
                'ok_del'=>false,
                'created_at'=>"=NOW()"
            );
            $res = $this->dbh->insert('orders', $orderdata);
            if(!$res){
                $this->dbh->rollback();
                return false;
            }

            foreach ($trolleys as $trolley){
                $orderDetailData = array(
                    "order_no" =>$orderdata['order_no'],
                    "goods_sysno" =>$trolley['goods_sysno'],
                    "number" =>$trolley['number'],
                    "status" =>1,
                    "ok_del" =>false,
                    'created_at'=>"=NOW()"
                );
                $res = $this->dbh->insert('orders_detail', $orderDetailData);
                if (!$res) {
                    $this->dbh->rollback();
                    return false;
                }
            }

            $this->dbh->commit();
            return $orderdata;
        } catch (Exception $e) {
            $this->dbh->rollback();
            return false;
        }
    }

    /**
     * 更新订单
     */
    public function updateOrder($order_no,$data){
        return $this->dbh->update('orders', $data, "order_no = '$order_no'");
    }

}