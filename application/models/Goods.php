<?php
/**
 * Created by PhpStorm.
 * User: 129
 * Date: 2018/4/4
 * Time: 16:54
 */
class GoodsModel{
    /**
     * 数据库类实例
     * @var object
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
     * 查询商品列表
     * @param $params
     * @return array
     */
    public function searchgoods($params){
        $filter = array();
        if (isset($params['merchant_name']) && $params['merchant_name'] != '') {
            $filter[] = " zc.`merchant_name` LIKE '%".$params['merchant_name']."%' ";
        }
        if (isset($params['goodsno']) && $params['goodsno'] != '') {
            $filter[] = " goods.`goodsno` LIKE '%".$params['goodsno']."%' ";
        }
        if (isset($params['goodsname']) && $params['goodsname'] != '') {
            $filter[] = " goods.`goodsname` LIKE '%".$params['goodsname']."%' ";
        }
        $where =" WHERE goods.`status` = 1  AND goods.`ok_del` = 0 ";
        if (1 <= count($filter)) {
            $where .= "AND ". implode(' AND ', $filter);
        }

        $sql = "SELECT count(goods.`sysno`) FROM `goods` 
                LEFT JOIN user_merchant um ON um.merchant_no = goods.merchant_no
                {$where} GROUP BY goods.sysno ";
        $result['totalRow']=$this->dbh->select_one($sql);
        if($result['totalRow']){
            if(!isset($params['page'])||$params['page'] == false){
                $sql = "SELECT goods.sysno,goods.goodsname,goods.price,um.merchant_name,ga.path,ga.name
                        FROM `goods`
                        LEFT JOIN user_merchant um ON um.merchant_no = goods.merchant_no
                        LEFT JOIN goods_attach ga ON ga.goods_sysno = goods.sysno
                        $where AND ga.use = 0 ";
                $result['list'] = $this->dbh->select($sql);
            }else{
                $sql = "SELECT goods.sysno,goods.goodsname,goods.price,um.merchant_name,ga.path,ga.name
                        FROM `goods`
                        LEFT JOIN user_merchant um ON um.merchant_no = goods.merchant_no
                        LEFT JOIN goods_attach ga ON ga.goods_sysno = goods.sysno
                        $where AND ga.use = 0 ";
                $result['list'] = $this->dbh->select_page($sql);
            }

        }
        return $result;
    }

    /**
     * 通过商品id查询商品详情
     * @param $id
     * @return mixed
     */
    public function getGoodsdetailbyId($id){
        $sql = "SELECT cg.sysno,cg.goodsname,cg.price,cm.sysno merchant_sysno,cm.merchant_name,cga.path,cga.name FROM `goods` cg
                LEFT JOIN user_merchant cm ON cm.merchant_no = cg.merchant_no
                LEFT JOIN goods_attach cga ON cga.goods_sysno = cg.sysno
                WHERE cg.sysno = $id";
        return $this->dbh->select_row($sql);
    }

}