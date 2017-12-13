<?php
namespace V1\Common;
use Think\Controller;
class ApiController extends Controller {

	public function __construct(){
		parent::__construct();
		$this->checkLogin();
	}

	private function checkLogin(){
		$path_info = I('server.PATH_INFO', '');
		if($path_info === 'user/login')
		{
			return TRUE;
		}
		$path_info = explode('/', $path_info);
		if(empty($path_info[0]) || empty($path_info[1]))
		{
			$this->apiReturn('url错误', FALSE);
		}
		if(empty(session('user')))
		{
			$this->goLogin();
		}
	}

	protected function goLogin()
	{
		$result = array(
			'code'    => 2,
			'message' => '请登录',
			'data'    => NULL
		);
		$this->ajaxReturn($result);
	}

	protected function apiReturn($data = array(), $correct = TRUE)
	{
		$result = array(
			'code'    => 0,
			'data'    => $data
		);
		if( ! $correct)
		{
			$result = array(
				'code'    => 1,
				'message' => $data
			);
		}
		$this->ajaxReturn($result);
	}

}