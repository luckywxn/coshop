<?php

/**
 * Created by PhpStorm.
 * User: 129
 * Date: 2017/8/25
 * Time: 16:25
 */
class ShoppingtrolleyModel
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
     * 查询购物车
     * @param $params
     * @return mixed
     */
    public function searchShoppingtrolley($params){
        $filter = array();
        if (isset($params['member_no']) && $params['member_no'] != '') {
            $filter[] = " cu.`member_no` = '{$params['member_no']}' ";
        }
        $where =" WHERE cst.`ok_del` = 0 ";
        if (1 <= count($filter)) {
            $where .= "AND ". implode(' AND ', $filter);
        }
        $orders = " ORDER BY cst.created_at DESC";

        $sql = "SELECT count(cst.`sysno`) FROM `shopping_trolley` cst
                LEFT JOIN user_member cu ON cu.member_no = cst.member_no $where";
        $totalRow = $this->dbh->select($sql);
        $result['totalRow'] = $totalRow;
        if($result['totalRow']){
            if(isset($params['page'])&&$params['page'] == false){
                $sql = "SELECT cst.sysno,cst.number,cu.nick_name,cg.goodsno,cg.goodsname,cg.price,cm.merchant_name,cga.path,cga.name
                        FROM `shopping_trolley` cst
                        LEFT JOIN user_member cu ON cu.member_no = cst.member_no
                        LEFT JOIN goods cg ON cg.sysno = cst.goods_sysno
                        LEFT JOIN user_merchant cm ON cm.merchant_no = cg.merchant_no
                        LEFT JOIN goods_attach cga ON cga.goods_sysno = cg.sysno
                        $where $orders";
                $result['list'] = $this->dbh->select($sql);
            }else{
                $result['totalPage'] = ceil($result['totalRow'] / $params['pageSize']);
                $this->dbh->set_page_num($params['pageCurrent']);
                $this->dbh->set_page_rows($params['pageSize']);
                $sql = "SELECT cst.sysno,cst.number,cu.nick_name,cg.goodsno,cg.goodsname,cg.price,cc.merchant_name,cga.path,cga.name
                        FROM `shopping_trolley` cst
                        LEFT JOIN user_member cu ON cu.member_no = cst.member_no
                        LEFT JOIN goods cg ON cg.sysno = cst.goods_sysno
                        LEFT JOIN user_merchant cm ON cm.merchant_no = cg.merchant_no
                        LEFT JOIN goods_attach cga ON cga.goods_sysno = cg.sysno
                        $where $orders";
                $result['list'] = $this->dbh->select_page($sql);
            }
        }
        return $result;
    }

    /**
     * 查询购物车
     */
    public function gettrolleybyid($id){
        $sql = "SELECT * FROM shopping_trolley WHERE sysno = $id";
        return $this->dbh->select_row($sql);
    }

    /**
     * 加入购物车
     */
    public function addtrolley($input){
        return $this->dbh->insert('shopping_trolley', $input);
    }

    /**
     * 更新购物车
     */
    public function updatetrolley($id,$input){
        return $this->dbh->update('shopping_trolley', $input, 'sysno=' . intval($id));
    }

    /**
     * 批量新购物车
     */
    public function updatetrolleys($ids,$input){
        return $this->dbh->update('shopping_trolley', $input, 'sysno IN (' . intval($ids) .')');
    }

    /**
     * 根据购物车ids查询商品
     */
    public function getGoodsByIds($ids){
        $sql = "SELECT * FROM `shopping_trolley` WHERE sysno IN ($ids)";
        $result = $this->dbh->select($sql);
        return $result;
    }

    /**
     * 根据购物车ids查询商品详情
     */
    public function getGoodsDetailByIds($ids){
        $sql = "SELECT cst.sysno,cst.number,cst.goods_sysno,cg.goodsno,cg.goodsname,cg.price,cst.number*cg.price totalprice,cm.merchant_name,cga.path,cga.name
                        FROM `shopping_trolley` cst
                        LEFT JOIN goods cg ON cg.sysno = cst.goods_sysno
                        LEFT JOIN user_merchant cm ON cm.merchant_no = cg.merchant_no
                        LEFT JOIN goods_attach cga ON cga.goods_sysno = cg.sysno
                        WHERE cst.sysno IN ($ids)";
        $result = $this->dbh->select($sql);
        return $result;
    }



}