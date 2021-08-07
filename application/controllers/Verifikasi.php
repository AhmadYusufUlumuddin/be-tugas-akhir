<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Verifikasi extends CI_Controller {

	public $result = array();

	function __construct()
	{
		parent::__construct();
		$this->load->model('M_api');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index(){
		redirect(site_url('Verifikasi/confirm'));
	}

	public function confirm(){
		$id = $this->uri->segment(3);
		$where['id_tb_pengguna'] = $id;
		$update['status_konfirmasi'] = "SUDAH DIKONFIRMASI";
		if ($this->M_api->profil_ubah($where,$update)){
			$this->session->set_flashdata('info','<div class="alert alert-success alert-dismissable">Berhasil Diverifikasi</div>');
			$this->load->view('verifikasi');
		} else {
			$this->session->set_flashdata('info','<div class="alert alert-danger alert-dismissable">Gagal Diverifikasi</div>');
			$this->load->view('verifikasi');
		}
	}
}
