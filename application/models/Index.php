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
        $sql = "SELECT cg.sysno,cg.goodsname,cg.price,um.merchant_name,cga.path,cga.name
                FROM `goods` cg
                LEFT JOIN user_merchant um ON um.merchant_no = cg.merchant_no
                LEFT JOIN goods_attach cga ON cga.goods_sysno = cg.sysno
                WHERE cg.`ok_del` = 0 AND cg.status = 1 AND cga.use = 0 AND cg.classify_sysno = $type";
        return $this->dbh->select($sql);
    }

}