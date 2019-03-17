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

    public function searchShoppingtrolley($params){
        $filter = array();
        if (isset($params['sysno']) && $params['sysno'] != '') {
            $filter[] = " cu.`sysno` = ".$params['sysno']." ";
        }
        $where =" WHERE cst.`isdel` = 0 ";
        if (1 <= count($filter)) {
            $where .= "AND ". implode(' AND ', $filter);
        }
        $orders = " ORDER BY cst.created_at DESC";

        $sql = "SELECT count(cst.`sysno`) FROM `concap_shopping_trolley` cst
                LEFT JOIN concap_user cu ON cu.sysno = cst.user_sysno $where";
        $totalRow = $this->dbh->select($sql);
        $result['totalRow'] = count($totalRow);
        if($result['totalRow']){
            if(isset($params['page'])&&$params['page'] == false){
                $sql = "SELECT cst.sysno,cst.number,cu.nickname,cg.goodsno,cg.goodsname,cg.price,cc.companyname,cga.path,cga.name
                        FROM `concap_shopping_trolley` cst
                        LEFT JOIN concap_user cu ON cu.sysno = cst.user_sysno
                        LEFT JOIN concap_goods cg ON cg.sysno = cst.goods_sysno
                        LEFT JOIN concap_company cc ON cc.sysno = cg.company_sysno
                        LEFT JOIN concap_goods_attach cga ON cga.goods_sysno = cg.sysno
                        $where $orders";
                $result['list'] = $this->dbh->select($sql);
            }else{
                $result['totalPage'] = ceil($result['totalRow'] / $params['pageSize']);
                $this->dbh->set_page_num($params['pageCurrent']);
                $this->dbh->set_page_rows($params['pageSize']);
                $sql = "SELECT cst.sysno,cst.number,cu.nickname,cg.goodsno,cg.goodsname,cg.price,cc.companyname,cga.path,cga.name
                        FROM `concap_shopping_trolley` cst
                        LEFT JOIN concap_user cu ON cu.sysno = cst.user_sysno
                        LEFT JOIN concap_goods cg ON cg.sysno = cst.goods_sysno
                        LEFT JOIN concap_company cc ON cc.sysno = cg.company_sysno
                        LEFT JOIN concap_goods_attach cga ON cga.goods_sysno = cg.sysno
                        $where $orders";
                $result['list'] = $this->dbh->select_page($sql);
            }
        }
        return $result;
    }

    /*
     * 查询购物车
     */
    public function gettrolleybyid($id){
        $sql = "SELECT * FROM concap_shopping_trolley WHERE sysno = $id";
        return $this->dbh->select_row($sql);
    }

    /*
     * 加入购物车
     */
    public function addtrolley($input){
        return $this->dbh->insert('concap_shopping_trolley', $input);
    }

    /*
     * 更新购物车
     */
    public function updatetrolley($id,$input){
        return $this->dbh->update('concap_shopping_trolley', $input, 'sysno=' . intval($id));
    }


}