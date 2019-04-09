<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2019/4/9
 * Time: 18:20
 */

class FavoriteModel
{
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
     * 查询收藏商品
     * @param $params
     * @return array
     */
    public function getFavoriteGoodsByMemberNo($memberno){
        $sql = "SELECT goods.sysno,goods.goodsname,goods.price,um.merchant_name,ga.path,ga.name
                FROM `goods`
                LEFT JOIN user_merchant um ON um.merchant_no = goods.merchant_no
                LEFT JOIN goods_attach ga ON ga.goods_sysno = goods.sysno
                LEFT JOIN user_member_favorite umf ON umf.collect_sysno = goods.sysno
                WHERE umf.member_no = '$memberno' AND collect_type = 1 AND ga.use = 0 ";
        $result['list'] = $this->dbh->select($sql);
        return $result;
    }

    /**
     * 添加到收藏夹
     * @param $data
     */
    public function addFavorite($data){
        return $this->dbh->insert('user_member_favorite', $data);
    }


}