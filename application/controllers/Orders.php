<?php

/**
 * Created by PhpStorm.
 * User: 129
 * Date: 2017/8/25
 * Time: 16:18
 */
class OrdersController extends Yaf_Controller_Abstract
{
    /**
     * GoodsController::init()
     */
    public function init() {
        # parent::init();
    }

    /*
     * 商品列表
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

        $order = new OrdersModel(Yaf_Registry::get("db"),Yaf_Registry::get('mc'));
        $list =  $order->searchOrders($search);
//        echo "<pre>";var_dump($list['list']);exit;
        $params['orders'] = $list['list'];
        $this->getView()->make('orders.list',$params);
    }

    /*
     * 商品列表数据
     */
    public function listJsonAction(){
        $request = $this->getRequest();
        $search = array(
            'companyname' => $request->getPost('companyname',''),
            'goodsno' => $request->getPost('goodsno',''),
            'goodsname' => $request->getPost('goodsname',''),
            'pageSize' => COMMON::PR(),
            'pageCurrent' => COMMON::P(),
        );

        $Orders = new OrdersModel(Yaf_Registry::get("db"),Yaf_Registry::get('mc'));
        $list =  $Orders->searchOrders($search);
        echo json_encode($list);
    }


    /**
     * 添加、修改商品
     */
    public function editAction()
    {
        $request = $this->getRequest();
        $id = $request->getParam('id',0);
        $G = new GoodsModel(Yaf_Registry::get('db'),Yaf_Registry::get('mc'));
        if(!$id){
            $action = "/goods/NewJson/";
            $params =  array ();
        } else {
            $action = "/goods/EditJson/";
            $params = $G->getGoodsById($id);
        }
        $C = new CompanyModel(Yaf_Registry::get('db'),Yaf_Registry::get('mc'));
        $search = array(
            'page' =>false
        );
        $companys = $C ->searchCompany($search);
        $classifys = $G ->getclassifys();
        $A = new AttachmentModel(Yaf_Registry:: get("db"), Yaf_Registry:: get('mc'));
        $attach = $A->getAttachByMAS(0,$id);
        $attach1 = $A->getAttachByMAS(1,$id);
        if (is_array($attach) && count($attach)) {
            $files1 = array();
            foreach ($attach as $file) {
                $files1[] = $file['sysno'];
            }
            $params['logoimg'] = join(',', $files1);
        }
        if (is_array($attach1) && count($attach1)) {
            $files2 = array();
            foreach ($attach1 as $file) {
                $files2[] = $file['sysno'];
            }
            $params['detailimg'] = join(',', $files2);
        }

        $params['id'] = $id;
        $params['action'] =  $action;
        $params['companys'] =  $companys['list'];
        $params['classifys'] =  $classifys;
        $this->getView()->make('goods.edit',$params);

    }

    /*
     * 添加商品操作
     */
    public function NewJsonAtion(){
        $request = $this->getRequest();
        $input = array(
            'company_sysno'  =>  $request->getPost('company_sysno',''),
            'classify_sysno'  =>  $request->getPost('classify_sysno',''),
            'goodsno'       =>  $request->getPost('goodsno',''),
            'goodsname'     =>  $request->getPost('goodsname',''),
            'price'     =>  $request->getPost('price',''),
            'memo'     =>  $request->getPost('memo',''),
            'status'        =>  $request->getPost('status','1'),
            'isdel'         =>  $request->getPost('isdel','0'),
            'created_at'    =>'=NOW()',
            'updated_at'    =>'=NOW()'
        );

        $G = new GoodsModel(Yaf_Registry::get('db'),Yaf_Registry::get('mc'));
        if($id = $G->addGoods($input))
        {
            $row = $G->getGoodsById($id);
            COMMON::result(200,'添加成功',$row);
        }else{
            COMMON::result(300,'添加失败');
        }

    }

    /**
     * 根据ID修改商品信息
     */
    public function EditJsonAtion()
    {
        $request = $this->getRequest();
        $id = $request->getPost('id',0);
//        var_dump($id);exit;
        $input = array(
            'company_sysno'  =>  $request->getPost('company_sysno',''),
            'classify_sysno'  =>  $request->getPost('classify_sysno',''),
            'goodsno'       =>  $request->getPost('goodsno',''),
            'goodsname'     =>  $request->getPost('goodsname',''),
            'price'     =>  $request->getPost('price',''),
            'memo'     =>  $request->getPost('memo',''),
            'status'        =>  $request->getPost('status','1'),
            'isdel'         =>  $request->getPost('isdel','0'),
            'created_at'    =>'=NOW()',
            'updated_at'    =>'=NOW()'
        );
        $G = new GoodsModel(Yaf_Registry::get('db'),Yaf_Registry::get('mc'));
        if($G->updateGoods($input,$id))
        {
            $row = $G->getGoodsById($id);
            COMMON::result(200,'修改成功',$row);
        }else{
            COMMON::result(300,'修改失败');
        }

    }

}