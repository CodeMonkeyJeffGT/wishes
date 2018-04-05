<?php
namespace V1\Controller;
use V1\Common\ApiController;
class UserController extends ApiController {
	
	private $user;

	public function __construct(){
		parent::__construct();
		$this->user = D('user');
	}

	public function info() {
		$au_id = session('acc');
		$this->apiReturn($this->user->studentInfo($au_id));
	}

	public function login()
	{
		$account = I('post.account');
		$password = I('post.password');

		if($this->user->login($account, $password))//登陆成功
		{
			$this->apiReturn();
		}
		else//登陆失败
		{
			$this->apiReturn($this->user->getError(), false);
		}
	}

	public function loginPage()
	{
		if(empty(session('openid')))
		{
			if( ! empty(session('user')) || ! empty(session('acc')))
			{
				header('location:/');die;
			}
			if( ! isset($_GET['code']))
			{
				$redirect_uri = 'http://nefuer.jblog.info/home/user/wx_in?redirect=' . urlencode($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . U('/V1/user/loginPage'));
				$this->wx->userCode($redirect_uri, false, 'redirect');
			}
			$openid = $this->wx->userOpenid(I('get.code'));
			if( ! empty($openid['errcode']))
				$this->apiReturn($openid['errmsg'], false);
			$openid = $openid['openid'];
			session('openid', $openid);
		}
		else
		{
			$openid = session('openid');
		}
		$u_id = $this->user->inByOpenid($openid);
		if( ! $u_id)
		{
			//加载登录页面
			die;
		}
		session('user', $u_id);
		header('location:/');die;
	}


}