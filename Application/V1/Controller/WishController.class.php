<?php
namespace V1\Controller;
use V1\Common\ApiController;
class WishController extends ApiController {
	
	protected $wish;

	public function __construct()
	{
		parent::__construct();
		$this->wish = D('wish');
	}

	public function list()
	{
		$u_id = session('user');
		if(empty($u_id))
			$this->goLogin();
		$list = $this->wish->list($u_id);
		$this->apiReturn($list);
	}

	public function nefuerPage()
	{
		header('location:/1217/list.html');die;
	}

	public function listAll()
	{
		$au_id = session('acc');
		if(empty($au_id))
			$this->goLogin();
		$this->apiReturn($this->wish->listAll($au_id));
	}

	public function pubPage()
	{
		$user = D('user');
		$userInfo = $user->userInfo(session('user'));
		if(false === $userInfo)
		{
			$this->apiReturn($user->getError(), false);
		}
		$this->apiReturn($userInfo);
	}

	public function pub()
	{
		$data = I('post.');
		$u_id     = session('user');
		$content  = $data['content'];
		$img      = $data['img'];
		$guy      = $data['guy'];
		$phone    = $data['phone'];
		$deadline = $data['deadline'];

		$user = D('user');
		$userInfo = $user->userInfo(session('user'));
		if(false === $userInfo)
		{
			$this->apiReturn($user->getError(), false);
		}
		if(empty($content))
			$this->apiReturn('请填写心愿内容', false);
		if(empty($guy))
			$this->apiReturn('请填写联系人', false);
		if(empty($phone))
			$this->apiReturn('请填写联系方式', false);
		if(empty($deadline))
			$this->apiReturn('请填写截止时间', false);
		$deadline = strtotime($deadline . ':00');
		if($deadline - time() < 900)
			$this->apiReturn('截止时间至少为15分钟，请修改', false);

		$this->wish->pub($u_id, $content, $img,  $guy, $phone, $deadline);
		$this->apiReturn();
	}

	public function info()
	{
		$id = I('get.id');
		if(empty($id))
			$this->apiReturn('请指定心愿id', false);

		$wishInfo = $this->wish->wishInfo($id);
		if(false === $wishInfo)
		{
			$this->apiReturn($this->wish->getError(), false);
		}
		$this->apiReturn($wishInfo);
	}

	public function cancel()
	{
		$id = I('post.id');
		$reason = I('post.reason');
		if(empty($id))
			$this->apiReturn('请指定心愿id', false);
		if(empty($reason))
			$this->apiReturn('请填写取消原因', false);
		$wishCancel = $this->wish->cancel($id, $reason);
		if(false === $wishCancel)
		{
			$this->apiReturn($this->wish->getError(), false);
		}
		$this->apiReturn();
	}

	public function accept()
	{
		$u_id = session('acc');
		if(empty($u_id))
			$this->apiReturn('请使用学生端登录');
		$data = I('post.');
		$id = $data['id'];
		$guy = $data['guy'];
		$phone = $data['phone'];
		if(empty($id))
			$this->apiReturn('请指定心愿id', false);
		if(empty($guy))
			$this->apiReturn('请填写联系人', false);
		if(empty($phone))
			$this->apiReturn('请填写联系方式', false);

		$wishAccept = $this->wish->accept($id, $u_id, $guy, $phone);
		if(false === $wishAccept)
		{
			$this->apiReturn($this->wish->getError(), false);
		}
		$this->apiReturn();
	}

	public function confirm()
	{
		$id = I('post.id');
		$time = I('post.time');
		$quality = I('post.judge');
		$u_id = session('user');
		if(empty($id))
			$this->apiReturn('请指定心愿id', false);
		$wishConfirm = $this->wish->confirm($id, $u_id, $time, $quality);
		if(false === $wishConfirm)
		{
			$this->apiReturn($this->wish->getError(), false);
		}
		$this->apiReturn();
	}
}