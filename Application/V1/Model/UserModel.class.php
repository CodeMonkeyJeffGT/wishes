<?php
namespace V1\Model;
use Think\Model;
class UserModel extends Model {

	private $errmsg; //错误信息

	public function inByOpenid($openid)
	{
		$sql = '
			SELECT `id`
			FROM `user`
			WHERE `openid` = "%s";
		';
		$user = $this->query($sql, $openid);
		if(empty($user))
			return FALSE;
		else
			return $user[0]['id'];
	}

	public function login($account, $password)
	{
		$sql = '
			SELECT `id`, `openid`, `password`
			FROM `user`
			WHERE `accnout` = "%s";
		';
		$user = $this->query($sql, $account);
		if(empty($user))
		{
			$this->errmsg = '用户账号不存在';
			return FALSE;
		}
		if($user[0]['password'] !== md5($password))
		{
			$this->errmsg = '密码错误';
			return FALSE;
		}
		session('user', $user[0]['id']);
		if( ! empty(session('openid')) && session('openid') !== $user[0]['openid'])
		{
			$sql = '
				UPDATE `user`
				SET `openid` = "%s"
				WHERE `id` = %d;
			';
			$this->execute($sql, sesison('openid'), $user[0]['id']);
		}
	}

	public function getError()
	{
		return $this->errmsg;
	}
}