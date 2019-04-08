<?php
use Gregwar\Captcha\CaptchaBuilder;
require_once('Ucpaas.class.php');

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
        //推荐商品
        $recommendGoods = $Index ->getgoods(1);
        foreach($recommendGoods as $key =>$good){
            if(strlen($good['goodsname'])>48){
                $goods[$key]['goodsname'] = substr($good['goodsname'],0,41)."...";

            }
        }
        $params['recommendGoods'] = $recommendGoods;
		//热销商品
		$hotGoods = $Index ->getgoods(2);
		foreach($hotGoods as $key =>$good){
			if(strlen($good['goodsname'])>48){
				$goods[$key]['goodsname'] = substr($good['goodsname'],0,41)."...";

			}
		}
		$params['hotGoods'] = $hotGoods;
		$this->getView()->make('index.index',$params);
	}

	/**
	 * 显示登陆页面
	 */
	public function LoginAction(){
		$params = array();
		$this->getView()->make('index.login',$params);
	}

    /**
     * 登录操作
     */
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
            setcookie ( "u_id", $user['sysno'], 0, "/", '.' . WEB_DOMAIN );
            Yaf_Session::getInstance ()->set ( SSN_VAR, $user );
			$userUpdate = array('lastlogintime'=>'=NOW()','lastloginip'=>$ip);
//			if($S->setUserInfo($userUpdate,$user['sysno']))
//			{
//				unset($user['userpwd']);
//				setcookie ( "u_id", $user['sysno'], 0, "/", '.' . WEB_DOMAIN );
//				Yaf_Session::getInstance ()->set ( SSN_VAR, $user );
//			}
			header("Location: /" );
		}else {
			$messgin['msg'] = "用户名或密码错误";
			$this->getView()->make('index.login', $messgin);
		}
	}

	/**
	 * 注销
	 */
	public function logOutAction()
	{
		$arr = array ();
		Yaf_Session::getInstance ()->set ( SSN_VAR, $arr );
		header("Location: /index/login");
	}

	/**
     * 显示注册页面
     */
	public function registerAction(){
        $params = array();
        $this->getView()->make('index.register',$params);
    }

    /**
     * 注册提交
     */
    public function registerJsonAction(){
        $request = $this->getRequest();
        $username = $request->getPost('username','');
        $code = $request->getPost('captcha','');
        $U = new UserModel(Yaf_Registry :: get("db"), Yaf_Registry :: get('mc'));
        if($code !=$_SESSION['vcode']){
            $data = array('code'=>501,'mes'=>'验证码错误！');
            echo json_encode($data);
            exit;
        }
        if($U->checkUserIsExist($username)){
            $data = array('code'=>502,'mes'=>'该用户已存在，不能重复注册！');
            echo json_encode($data);
            exit;
        }
        $input = array(
            'member_no'=>COMMON::getCodeId("M"),
            'member_type'=>1, //用户
            'user_name'=>$request->getPost('username',''),
            'mobile_number'=>$request->getPost('username',''),
            'member_status'=>2,//启用
            'created_at'	=>'=NOW()'
        );
        $security = array(
            'member_no'=>$input['member_no'],
            'ok_login_password'=>true,
            'login_password'=> password_hash($request->getPost('passwordhash',''), 1, ['cost' => 10]),
        );
        if($U->addUser($input,$security)){
            $data = array('code'=>200,'mes'=>'恭喜你，注册成功！');
            echo json_encode($data);
        }else{
            $data = array('code'=>503,'mes'=>'注册失败！');
            echo json_encode($data);
        }
    }

    public function sendcodeAction(){
        session_start();
        $request = $this->getRequest();
        $phone = $request->getPost('phone','');
        //初始化必填
        $options['accountsid']='b697b82a3eb16547f9623f889a723a38';//29beef823c15b881cbca189007d527e1
        $options['token']='e12f50806ab6a038886c819df6f1875f';//5c580f164ee7dc6ce14acb8596e333b7
        $ucpass = new Ucpaas($options);

        $appId = "da199f96a35646b485e97554f583efa1";//969021d6705a4997b830a4dd6aa2b3b0
        $templateId = "452591";//13748
        $rand_number = rand ( 100000, 999999 );
        $_SESSION['vcode'] = $rand_number;
        $param="$rand_number,3";

        echo $ucpass->templateSMS($appId,$phone,$templateId,$param);
    }

}
