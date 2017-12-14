<?php
namespace V1\Model;
use Think\Model;
class WishModel extends Model {

	private $errmsg; //错误信息

	public function list($u_id)
	{
		$sql = '
			SELECT `id`, `time`, `deadline`, `content`
			FROM `wish`
			WHERE `u_id` = %d;
		';
		$wishes = $this->query($sql, $u_id);
		return $wishes;
	}

	public function pub($u_id, $content, $img,  $guy, $phone, $deadline)
	{
		$sql = '
			INSERT INTO `wish`(`u_id`, `content`, `img`, `guy`, `phone`, `deadline`, `created`)
			VALUES(%d, "%s", "%s", "%s", "%s", %d, %d);
		';
		$this->execute($sql, array($u_id, $content, $img, $guy, $phone, time()));
		return TRUE;
	}

	public function wishInfo($id)
	{
		$sql = '
			SELECT `content`, `img`, `guy`, `phone`, `deadline`, `created` `time`, `angel_guy`, `angel_phone`, `done`, `cancel_reason`
			FROM `wish`
			WHERE `id` = %d;
		';
		$wish = $this->query($sql, $id);
		if(empty($wish))
		{
			$this->errmsg = '心愿不存在';
			return FALSE;
		}
		$wish = $wish[0];
		if( ! empty($wish['cancel_reason']))
		{
			$this->errmsg = '心愿已被取消';
			return FALSE;
		}
		unset($wish['cancel_reason']);
		if( ! empty($wish['angel_guy']))
			$wish['angel'] = array(
				'guy' => $wish['angel_guy'],
				'phone' => $wish['angel_phone'],
				'done' => $wish['done']
			);
		unset($wish['angel_guy']);
		unset($wish['angel_phone']);
		unset($wish['done']);
		return $wish;
	}

	public function cancel($id, $reason)
	{
		$u_id = session('user');
		$sql = '
			SELECT `u_id`
			FROM `wish`
			WHERE `id` = %d;
		';
		$u_id_sql = $this->query($sql, $id);
		if(empty($u_id))
		{
			$this->errmsg = '心愿不存在';
			return FALSE;
		}
		if($u_id !== $u_id_sql[0]['u_id'])
		{
			$this->errmsg = '您不是该心愿的发布者';
			return FALSE;
		}
		$sql = '
			UPDATE `wish`
			SET `cancel_reason` = "%s", `cancel_time`
			WHERE `id` = %d;
		';
		$this->execute($sql, array($reason, time(), $id));
		return TRUE;
	}

	public function accept($id, $u_id, $guy, $phone)
	{
		$sql = '
			SELECT `angel_guy`
			FROM `wish`
			WHERE `id` = %d;
		';
		$accepted = $this->query($sql, $id);
		if(empty($accepted))
		{
			$this->errmsg = '心愿不存在';
			return FALSE;
		}
		if( ! empty($accepted[0]['angel_guy']))
		{
			$this->errmsg = '心愿已被接受';
			return FALSE;
		}

		$sql = '
			UPDATE `wish`
			SET `angel_id` = %d, `angel_guy` = "%s", `angel_phone` = "%s"
			WHERE `id` = %d;
		';
		$this->execute($sql, array($u_id, $guy, $phone, $id));
		return TRUE;
	}

	public function confirm($id)
	{
		$u_id = session('user');
		$sql = '
			SELECT `u_id`, `angel_guy`, `done`
			FROM `wish`
			WHERE `id` = %d;
		';
		$u_id_sql = $this->query($sql, $id);
		if(empty($u_id))
		{
			$this->errmsg = '心愿不存在';
			return FALSE;
		}
		if($u_id !== $u_id_sql[0]['u_id'])
		{
			$this->errmsg = '您不是该心愿的发布者';
			return FALSE;
		}
		if(empty($u_id[0]['angel_guy']))
		{
			$this->errmsg = '心愿未被接受';
			return FALSE;
		}
		if(($u_id【[0]['done']))
		{
			$this->errmsg = '心愿已完成';
			return FALSE;
		}
		$sql = '
			UPDATE `wish`
			SET `done` = 1
			WHERE `id` = %d;
		';
		$this->execute($sql, $id);
		return TRUE;
	}

	public function getError()
	{
		return $this->errmsg;
	}

}