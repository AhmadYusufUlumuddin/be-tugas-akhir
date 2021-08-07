<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		if (isset($this->session->userdata['login_admin']) == TRUE) {
			redirect(base_url("Admin"));
		}
		$this->load->model('M_login');
	}

	public function index()
	{
		$this->load->view('login');
	}

	public function login_execute()
	{
		$where['username']	= $this->input->post('username');
		$where['password']	= md5($this->input->post('password'));
		$check_admin=$this->M_login->login_admin($where);
		if ($check_admin->num_rows()>0){
			$data=$check_admin->row();
			$this->session->set_userdata(
				array(
					'id_tb_admin'=>$data->id_tb_admin,
					'username'=>$data->username,
					'login_admin'=>true
				)
			);
			redirect(base_url('Admin'));
		} else{
			$this->session->set_flashdata('info','<div class="alert alert-danger alert-dismissable">Nama Pengguna atau Password Tidak diketahui</div>');
			redirect(base_url());
		}
	}

}
