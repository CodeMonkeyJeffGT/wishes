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
			return false;
		else
			return $user[0]['id'];
	}

	public function login($account, $password)
	{
		$sql = '
			SELECT `id`, `openid`, `password`
			FROM `user`
			WHERE `account` = "%s";
		';
		$user = $this->query($sql, $account);
		if(empty($user))
		{
			$this->errmsg = '用户账号不存在';
			return false;
		}
		if($user[0]['password'] !== md5($password))
		{
			$this->errmsg = '密码错误';
			return false;
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
		return true;
	}

	public function userInfo($id)
	{
		$sql = '
			SELECT `nickname` `guy`, `phone`
			FROM `user`
			WHERE `id` = %d;
		';
		$user = $this->query($sql, $id);
		if(empty($user))
		{
			$this->errmsg = '用户不存在';
			return false;
		}
		$user[0]['deadline_d'] = date('Y-m-d', time() + 86400);
		$user[0]['deadline_t'] = date('H:i', time() + 86400);
		return $user[0];
	}

	public function studentInfo($id) {
		return $_SESSION;
	}

	public function getError()
	{
		return $this->errmsg;
	}
}