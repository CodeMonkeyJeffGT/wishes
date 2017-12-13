<?php
namespace V1\Controller;
use V1\Common\ApiController;
class UserController extends ApiController {

	public function login()
	{
		if(0)//登陆成功
		{
			$this->apiReturn();
			// $this->apiReturn(array('成功返回的数组，登陆没有返回可以空着'));
		}
		else//登陆失败
		{
			//apiReturn第二个参数表示操作成功或失败，默认为成功
			$this->apiReturn('账号不存在（错误信息，用作给用户提示）', FALSE);
		}
	}

}