<?php
use Gregwar\Captcha\CaptchaBuilder;

class IndexController extends Yaf_Controller_Abstract {
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
		$params['user']  = Yaf_Registry::get(SSN_VAR);
		$Index = new IndexModel(Yaf_Registry :: get("db"), Yaf_Registry :: get('mc'));
		//热销商品
		$goods = $Index ->getgoods(0);
		foreach($goods as $key =>$good){
			if(strlen($good['goodsname'])>48){
				$goods[$key]['goodsname'] = substr($good['goodsname'],0,41)."...";

			}
		}
		$params['Goods'] = array();//$goods
		//个人护理
		$personalgoods = $Index ->getgoods(2);
		foreach($personalgoods as $key =>$good){
			if(strlen($good['goodsname'])>48){
				$goods[$key]['goodsname'] = substr($good['goodsname'],0,41)."...";

			}
		}
		$params['Personalgoods'] = $personalgoods;
		//家居护理
		$homeCaregoods = $Index ->getgoods(3);
		foreach($homeCaregoods as $key =>$good){
			if(strlen($good['goodsname'])>48){
				$goods[$key]['goodsname'] = substr($good['goodsname'],0,41)."...";

			}
		}
		$params['HomeCaregoods'] = array();//$homeCaregoods;
//		echo "<pre>";var_dump($params['HomeCaregoods']);exit;
		$this->getView()->make('index.index',$params);
	}

	/*
	 * 显示登陆页面
	 */
	public function LoginAction(){
		$params = array();
		$this->getView()->make('index.login',$params);
	}

	public function UserLoginAction()
	{
		$request = $this->getRequest();
		$params['username'] = $request->getpost('username','');
		$params['userpwd'] = $request->getpost('passwordhash','');
//		var_dump($params);exit;

		$S = new UserModel(Yaf_Registry :: get("db"), Yaf_Registry :: get('mc'));
		if($user = $S->userLogin($params))
		{
			$ip = COMMON::getclientIp();
			$userUpdate = array('lastlogintime'=>'=NOW()','lastloginip'=>$ip);
			if($S->setUserInfo($userUpdate,$user['sysno']))
			{
				unset($user['userpwd']);
				setcookie ( "u_id", $user['sysno'], 0, "/", '.' . WEB_DOMAIN );
				Yaf_Session::getInstance ()->set ( SSN_VAR, $user );
			}
			header("Location: /" );
		}else {
			$messgin['msg'] = "用户名错误";
			$this->getView()->make('index.login', $messgin);
		}
	}

	/*
	 * 注销
	 */
	public function logOutAction()
	{
		$arr = array ();
		Yaf_Session::getInstance ()->set ( SSN_VAR, $arr );
		header("Location: /index/login");
	}

}
