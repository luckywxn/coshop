<?php
/**
 * Created by PhpStorm.
 * User: 129
 * Date: 2018/4/4
 * Time: 16:54
 */
class IndexModel{
    /**
     * 数据库类实例
     *
     * @var object
     */
    public $dbh = null;

    public $mch = null;

    /**
     * Constructor
     *
     * @param   object $dbh
     * @return  void
     */
    public function __construct($dbh, $mch = null)
    {
        $this->dbh = $dbh;
        $this->mch = $mch;
    }

    public function getgoods($type){
        $sql = "SELECT cg.sysno,cg.goodsname,cg.price,cc.companyname,cga.path,cga.name
                FROM `concap_goods` cg
                LEFT JOIN concap_company cc ON cc.sysno = cg.company_sysno
                LEFT JOIN concap_goods_attach cga ON cga.goods_sysno = cg.sysno
                WHERE cg.`isdel` = 0 AND cg.status = 1 AND cga.use = 0 ";
//echo $sql;exit;
        return $this->dbh->select($sql);
    }

}