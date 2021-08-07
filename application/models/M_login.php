<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_login extends CI_Model {

	public function login_admin($where)
	{
		return $this->db->where($where)->get('tb_admin');
	}

}
