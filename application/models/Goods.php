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

    public function searchgoods($params){
        $filter = array();
        if (isset($params['companyname']) && $params['companyname'] != '') {
            $filter[] = " zc.`companyname` LIKE '%".$params['companyname']."%' ";
        }
        if (isset($params['goodsno']) && $params['goodsno'] != '') {
            $filter[] = " `goodsno` LIKE '%".$params['goodsno']."%' ";
        }
        if (isset($params['goodsname']) && $params['goodsname'] != '') {
            $filter[] = " `goodsname` LIKE '%".$params['goodsname']."%' ";
        }
        $rows=$params['pageSize'];

        $where =" WHERE zg.`isdel` = 0 ";
        if (1 <= count($filter)) {
            $where .= "AND ". implode(' AND ', $filter);
        }
        $result=array('totalRow'=>0,'totalPage'=>0,'list'=>array());

        $sql = "SELECT count(zg.`sysno`) FROM `concap_goods` zg
                LEFT JOIN concap_company zc ON zc.sysno = zg.company_sysno
                {$where} GROUP BY zg.sysno ";
        $result['totalRow']=$this->dbh->select_one($sql);

        $result['totalPage'] = ceil($result['totalRow'] / $rows);

        $this->dbh->set_page_num($params['pageCurrent']);
        $this->dbh->set_page_rows($params['pageSize']);

        $sql = "SELECT zg.*,zc.companyname FROM `concap_goods` zg
                LEFT JOIN concap_company zc ON zc.sysno = zg.company_sysno ".$where;
        $result['list'] = $this->dbh->select_page($sql);

        return $result;
    }

    public function getGoodsdetailbyId($id){
        $sql = "SELECT cg.sysno,cg.goodsname,cg.price,cc.companyname,cga.path,cga.name FROM `concap_goods` cg
                LEFT JOIN concap_company cc ON cc.sysno = cg.company_sysno
                LEFT JOIN concap_goods_attach cga ON cga.goods_sysno = cg.sysno
                WHERE cg.sysno = $id";
        return $this->dbh->select_row($sql);
    }

}