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

}