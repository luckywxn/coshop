<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2019/4/9
 * Time: 18:18
 */

class FavoriteController extends Yaf_Controller_Abstract {

    /**
     * FavoriteController::init()
     * @return void
     */
    public function init() {
        # parent::init();
    }

    /**
     * 显示收藏列表
     */
    public function favoriteGoodsListAction() {
        $params['user']  = Yaf_Registry::get(SSN_VAR);
        $memberno = $params['user']['member_no'];
        $favorite = new FavoriteModel(Yaf_Registry :: get("db"), Yaf_Registry :: get('mc'));
        $favoriteres = $favorite ->getFavoriteGoodsByMemberNo($memberno);
        $params['list'] = $favoriteres['list'];
        $this->getView()->make('favorite.list',$params);
    }

    /**
     * 添加到收藏夹
     */
    public function addfavoriteAction(){
        $request = $this->getRequest();
        $input = array(
            'member_no'=> $request->getPost('member_no',""),
            'collect_type'=> $request->getPost('collect_type',0),
            'collect_sysno'=> $request->getPost('collect_sysno',0),
            'created_at' => '=NOW()'
        );
        $favorite = new FavoriteModel(Yaf_Registry::get("db"),Yaf_Registry::get('mc'));
        if($id = $favorite->addFavorite($input))
        {
            $data = array('code'=>200,'mes'=>'添加收藏成功');
            echo json_encode($data);
        }else{
            $data = array('code'=>300,'mes'=>'添加收藏失败');
            echo json_encode($data);
        }
    }

}