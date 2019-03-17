<?php

/**
 * Created by PhpStorm.
 * User: 129
 * Date: 2017/8/25
 * Time: 16:18
 */
class ShoppingtrolleyController extends Yaf_Controller_Abstract
{
    /**
     * GoodsController::init()
     */
    public function init() {
        # parent::init();
    }

    /*
     * 购物车列表
     */
    public function listAction(){
        $params['user']  = Yaf_Registry::get(SSN_VAR);
        if(!$params['user']){
            echo "<script>alert(\"请先登录\");</script>";
            $this->getView()->make('index.login', array());
        }
        $search = array(
            'sysno' => $params['user']['sysno'],
            'page' => false,
        );

        $Shoppingtrolley = new ShoppingtrolleyModel(Yaf_Registry::get("db"),Yaf_Registry::get('mc'));
        $list =  $Shoppingtrolley->searchShoppingtrolley($search);
        $params['trolleys'] = $list['list'];
        $this->getView()->make('shoppingtrolley.list',$params);
    }

    /*
     * 购物车商品数量编辑
     */
    public function updatenumAction(){
        $request = $this->getRequest();
        $id = $request->getPost('id',0);
        $input = array(
            'number'=> $request->getPost('num',0),
            'isdel'=> $request->getPost('isdel',0),
            'updated_at' => '=NOW()'
        );
        $Shoppingtrolley = new ShoppingtrolleyModel(Yaf_Registry::get("db"),Yaf_Registry::get('mc'));
        if($id = $Shoppingtrolley->updatetrolley($id,$input))
        {
            $data = array('code'=>200,'mes'=>'添加成功');
            echo json_encode($data);
        }else{
            $data = array('code'=>300,'mes'=>'添加失败');
            echo json_encode($data);
        }
    }

}