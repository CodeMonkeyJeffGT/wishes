<?php
namespace V1\Controller;
use V1\Common\ApiController;
class WishController extends ApiController {
	protected $use_wx = TRUE;
	protected $wish;

	public function __construct()
	{
		parent::__construct();
		$this->wish = D('wish');
	}

	public function list()
	{
		$u_id = session('user');
		$list = $this->wish->list($u_id);
		$this->apiReturn($list);
	}

	public function pubPage()
	{
		$user = D('user');
		$userInfo = $user->userInfo();
		if(FALSE === $userInfo)
		{
			$this->apiReturn($user->getError(), FALSE);
		}
		return $userInfo;
	}

	public function pub()
	{
		
	}
}