<?php
namespace V1\Model;
use Think\Model;
class WishModel extends Model {

	private $errmsg; //错误信息

	public function list($u_id)
	{
		$sql = '
			SELECT `id`, `created`, `deadline`, `content`, `angel_id`
			FROM `wish`
			WHERE `u_id` = %d AND (`deadline` > %d OR `angel_id` <> 0) AND `cancel_time` = 0;
		';
		$wishes = $this->query($sql, $u_id, time());
		$wish_arr = array(
			'accepted' => array(),
			'unaccepted' => array()
		);
		for($i = 0, $iloop =count($wishes); $i < $iloop; $i++)
		{
			$wishes[$i]['time'] = date('m月d日 H:s', $wishes[$i]['created']);
			unset($wishes[$i]['created']);
			$wishes[$i]['deadline'] = date('m月d日 H:s', $wishes[$i]['deadline']);

			if(empty($wishes[$i]['angel_id']))
			{
				unset($wishes[$i]['angel_id']);
				$wish_arr['unaccepted'][] = $wishes[$i];
			}
			else
			{
				unset($wishes[$i]['angel_id']);
				$wish_arr['accepted'][] = $wishes[$i];
			}
		}
		return $wish_arr;
	}

	public function listAll($au_id)
	{
		$sql = '
			SELECT `id`, `created`, `deadline`, `content`, `angel_id`, `done`
			FROM `wish`
			WHERE (`angel_id` = 0 AND `deadline` > %d AND `cancel_time` = 0)
				OR (`angel_id` = %d)
			ORDER BY `done` DESC;
		';
		$wishes = $this->query($sql, time(), $au_id);
		$wish_arr = array(
			'accepted' => array(),
			'unaccepted' => array()
		);
		for($i = 0, $iloop =count($wishes); $i < $iloop; $i++)
		{
			$wishes[$i]['time'] = date('m月d日 H:s', $wishes[$i]['created']);
			unset($wishes[$i]['created']);
			$wishes[$i]['deadline'] = date('m月d日 H:s', $wishes[$i]['deadline']);

			if(empty($wishes[$i]['angel_id']))
			{
				unset($wishes[$i]['angel_id']);
				$wish_arr['unaccepted'][] = $wishes[$i];
			}
			elseif($wishes[$i]['done'] == 0)
			{
				unset($wishes[$i]['angel_id']);
				$wish_arr['accepted'][] = $wishes[$i];
			} else {
				unset($wishes[$i]['angel_id']);
				$wish_arr['done'][] = $wishes[$i];
			}
		}
		return $wish_arr;
	}

	public function pub($u_id, $content, $img,  $guy, $phone, $deadline)
	{
		$sql = '
			INSERT INTO `wish`(`u_id`, `content`, `img`, `guy`, `phone`, `deadline`, `created`)
			VALUES(%d, "%s", "%s", "%s", "%s", %d, %d);
		';
		$this->execute($sql, $u_id, $content, $img, $guy, $phone, $deadline, time());
		return true;
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
			return false;
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
		$week = array('日', '一', '二', '三', '四', '五', '六');
		$wish['time'] = date('m月d日 星期', $wish['time']) . $week[date('w', $wish['time'])] . date(' H:s', $wish['time']);
		$wish['deadline'] = date('m月d日 星期', $wish['deadline']) . $week[date('w', $wish['deadline'])] . date(' H:s', $wish['deadline']);
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
			WHERE `id` = %d AND `cancel_time` = 0;
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
			SET `cancel_reason` = "%s", `cancel_time` = %d
			WHERE `id` = %d;
		';
		$this->execute($sql, array($reason, time(), $id));
		return true;
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
		return true;
	}

	public function confirm($id, $u_id, $time, $quality)
	{
		$sql = '
			SELECT `u_id`, `angel_id`, `done`
			FROM `wish`
			WHERE `id` = %d;
		';
		$u_id_sql = $this->query($sql, $id);
		if(empty($u_id_sql))
		{
			$this->errmsg = '心愿不存在';
			return FALSE;
		}
		if($u_id !== $u_id_sql[0]['u_id'])
		{
			$this->errmsg = '您不是该心愿的发布者';
			return FALSE;
		}
		if(empty($u_id_sql[0]['angel_id']))
		{
			$this->errmsg = '心愿未被接受';
			return FALSE;
		}
		if(($u_id_sql[0]['done']))
		{
			$this->errmsg = '心愿已完成';
			return FALSE;
		}
		switch ($quality) {
			case 'A':
				$quality = 100;
				break;
			case 'B':
				$quality = 80;
				break;
			case 'C':
				$quality = 60;
				break;
			case 'D':
				$quality = 40;
				break;
			default:
				$quality = 0;
				break;
		}
		$sql = '
			UPDATE `wish`
			SET `done` = 1, `work_time` = %d, `quality` = %d
			WHERE `id` = %d;
		';
		$this->execute($sql, $time, $quality, $id);
		return true;
	}

	public function getError()
	{
		return $this->errmsg;
	}

}