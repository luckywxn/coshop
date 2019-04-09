<?php
use Gregwar\Captcha\CaptchaBuilder;

class GoodsController extends Yaf_Controller_Abstract {

    /**
     * IndexController::init()
     * @return void
     */
    public function init() {
        # parent::init();
    }

    /**
     * 显示商品列表
     */
    public function goodsListAction() {
        $params['user']  = Yaf_Registry::get(SSN_VAR);
        $request = $this->getRequest();
        $Goods = new GoodsModel(Yaf_Registry :: get("db"), Yaf_Registry :: get('mc'));
        $search = array(
            "goodsname" =>$request->getPost('goodsname',""),
        );
        $params = $Goods ->searchgoods($search);

        $this->getView()->make('goods.list',$params);
    }

    /**
     * 显示商品详情页面
     */
    public function IndexAction() {
        $request = $this->getRequest();
        $id = $request->getParam('id',0);
        $Goods = new GoodsModel(Yaf_Registry :: get("db"), Yaf_Registry :: get('mc'));
        $params = $Goods ->getGoodsdetailbyId($id);
        $params['user']  = Yaf_Registry::get(SSN_VAR);
        $this->getView()->make('goods.detail',$params);
    }

    /**
     * 加入购物车
     */
    public function addtrolleyAction(){
        $request = $this->getRequest();
        $input = array(
            'member_no'=> $request->getPost('member_no',0),
            'goods_sysno'=> $request->getPost('goods_sysno',0),
            'number' => $request->getPost('num',0),
            'created_at' => '=NOW()',
            'updated_at' => '=NOW()'
        );
        $Shoppingtrolley = new ShoppingtrolleyModel(Yaf_Registry::get("db"),Yaf_Registry::get('mc'));
        if($id = $Shoppingtrolley->addtrolley($input))
        {
            $data = array('code'=>200,'mes'=>'添加成功');
            echo json_encode($data);
        }else{
            $data = array('code'=>300,'mes'=>'添加失败');
            echo json_encode($data);
        }
    }

}
