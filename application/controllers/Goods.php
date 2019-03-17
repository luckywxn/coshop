<?php
use Gregwar\Captcha\CaptchaBuilder;

class GoodsController extends Yaf_Controller_Abstract {
    /**
     * IndexController::init()
     *
     * @return void
     */
    public function init() {
        # parent::init();
        $user  = Yaf_Registry::get(SSN_VAR);
    }

    /**
     * 显示整个后台页面框架及菜单
     */
    public function IndexAction() {
        $request = $this->getRequest();
        $id = $request->getParam('id',0);
        $Goods = new GoodsModel(Yaf_Registry :: get("db"), Yaf_Registry :: get('mc'));
        $params = $Goods ->getGoodsdetailbyId($id);
        $params['user']  = Yaf_Registry::get(SSN_VAR);
        $this->getView()->make('goods.detail',$params);
    }

    /*
     * 加入购物车
     */
    public function addtrolleyAction(){
        $request = $this->getRequest();
        $input = array(
            'user_sysno'=> $request->getPost('user_sysno',0),
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
