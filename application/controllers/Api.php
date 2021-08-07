<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	public $result = array();

	function __construct()
	{
		parent::__construct();
		$this->load->model('M_api');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function signup()
	{
		$result = array();
		$input['nama'] = $this->input->post('nama');
		$input['email'] = $this->input->post('email');
		$input['alamat'] = $this->input->post('alamat');
		$input['jenis_kelamin'] = $this->input->post('jenis_kelamin');
		$input['password'] = md5($this->input->post('password'));
		$input['id_tb_provinsi'] = $this->input->post('id_tb_provinsi');
		$input['id_tb_kabupaten'] = $this->input->post('id_tb_kabupaten');
		$input['id_tb_kecamatan'] = $this->input->post('id_tb_kecamatan');
		$input['id_tb_kelurahan'] = $this->input->post('id_tb_kelurahan');
		$input['create_date'] = date('Y-m-d H:i:s');
		$stmt = $this->M_api->signup($input);
		if ($stmt) {
			$config = array(
				'mailtype'  => 'html',
				'charset'   => 'utf-8',
				'protocol'  => 'smtp',
				'smtp_host' => 'smtp.gmail.com',
				'smtp_user' => '@gmail.com',  // Email gmail
				'smtp_pass'   => '',  // Password gmail
				'smtp_crypto' => 'ssl',
				'smtp_port'   => 465,
				'crlf'    => "\r\n",
				'newline' => "\r\n"
			);

			$this->load->library('email', $config);
			$this->email->from('no-reply@ar-kacamata.com', 'AR Kacamata');
			$this->email->to($this->input->post('email'));
			$this->email->subject('Verifikasi Akun Bengkel');
			$this->email->message("Ini adalah pesan verifikasi dari aplikasi AR Kacamata. Silahakn klik tautan berikut untuk dapat mengkonfirmasi akun<br><br> Klik <strong><a href='".site_url('Verifikasi/confirm/'.$stmt)."' target='_blank' rel='noopener'>disini</a></strong>.");
			$this->email->send();
			$data = array('status'=>"1", 'id'=>$stmt);
			array_push($result,$data);
		} else {
			array_push($result,array('status'=>"0"));
		}
        $this->setJSON(array('result'=>$result));
	}


	public function signin()
	{
		$result = array();
		$where['tb_pengguna.email'] = $this->input->post('email');
		$where['tb_pengguna.password'] = md5($this->input->post('password'));
		$stmt = $this->M_api->signin($where);
		if ($stmt->num_rows() > 0) {
			$dt = $stmt->row();
			$data = array(
				'status'=>"1",
				'id_tb_pengguna'=>$dt->id_tb_pengguna,
				'nama'=>$dt->nama,
				'email'=>$dt->email,
				'alamat'=>$dt->alamat,
				'jenis_kelamin'=>$dt->jenis_kelamin,
				'id_tb_provinsi'=>$dt->id_tb_provinsi,
				'nama_provinsi'=>$dt->nama_provinsi,
				'id_tb_kabupaten'=>$dt->id_tb_kabupaten,
				'nama_kabupaten'=>$dt->nama_kabupaten,
				'id_tb_kecamatan'=>$dt->id_tb_kecamatan,
				'nama_kecamatan'=>$dt->nama_kecamatan,
				'id_tb_kelurahan'=>$dt->id_tb_kelurahan,
				'nama_kelurahan'=>$dt->nama_kelurahan,
				'status_konfirmasi'=>$dt->status_konfirmasi
			);
			array_push($result,$data);
		} else {
			array_push($result,array('status'=>"0"));
		}
        $this->setJSON(array('result'=>$result));
		
	}

	public function home()
	{
		$stmt = $this->M_api->kacamata_terbaru();
		$stmt2 = $this->M_api->kategori();
        $response = array(
        	'result' => $stmt->result(),
        	'result2' => $stmt2->result());
        $this->setJSON($response);
	}

	public function kacamata(){
		$id = $this->input->post('id_tb_kategori');
		if ($id!="0") {
			$where['tb_kacamata.id_tb_kategori'] = $id;
		}
		$where['tb_kacamata.del_flage'] = 1;		
		$stmt = $this->M_api->kacamata($where);
		$response = array('result' => $stmt->result());
		$this->setJSON($response);
	}

	public function kacamata_detail(){
		$where['tb_kacamata.id_tb_kacamata'] = $this->input->post('id_tb_kacamata');
		$where2['tb_kacamata_favorit.id_tb_kacamata'] = $this->input->post('id_tb_kacamata');
		$where2['tb_kacamata_favorit.id_tb_pengguna'] = $this->input->post('id_tb_pengguna');
		$where2['tb_kacamata_favorit.del_flage'] = 1;
		$stmt = $this->M_api->kacamata_detail($where);
		$stmt2 = $this->M_api->kacamata_favorit($where2)->num_rows();
		$response = array('result' => $stmt->result(), 'result2' => array('status'=>$stmt2));
		$this->setJSON($response);
	}

	public function kirim_favorit()
	{
		$result = array();
		$where['tb_kacamata_favorit.id_tb_kacamata'] = $id_kacamata = $this->input->post('id_tb_kacamata');
		$where['tb_kacamata_favorit.id_tb_pengguna'] = $id_pengguna = $this->input->post('id_tb_pengguna');
		$status_favorit = $this->input->post('status_favorit');
		$cek = $this->M_api->kacamata_favorit($where);
		if ($cek->num_rows() > 0) {
			if ($status_favorit == "HAPUS") {
				$update['del_flage'] = 0;
			} elseif ($status_favorit == "TAMBAH") {
				$update['del_flage'] = 1;
				$update['create_date']	 = date('Y-m-d H:i:s');
			}
			$stmt = $this->M_api->kacamata_favorit_update($where,$update);
		} else {
			$input['id_tb_pengguna'] = $id_pengguna;
			$input['id_tb_kacamata'] = $id_kacamata;
			$input['create_date']	 = date('Y-m-d H:i:s');
			$stmt = $this->M_api->kacamata_favorit_tambah($input);
		}
		if ($stmt){
			array_push($result,array('status'=>1));
		} else {
			array_push($result,array('status'=>0));
		}
		$this->setJSON(array('result'=>$result));
	}

	public function kacamata_favorit()
	{
		$where['tb_kacamata_favorit.id_tb_pengguna'] = $this->input->post('id_tb_pengguna');
		$where['tb_kacamata_favorit.del_flage'] = 1;
		$stmt = $this->M_api->kacamata_favorit($where);
		$response = array('result' => $stmt->result());
		$this->setJSON($response);
	}

	public function profil_ubah(){
		$result = array();
		$where['id_tb_pengguna'] = $this->input->post('id_tb_pengguna');
		$update['nama'] = $this->input->post('nama');
		$update['email'] = $this->input->post('email');
		$update['jenis_kelamin'] = $this->input->post('jenis_kelamin');
		$update['alamat'] = $this->input->post('alamat');
		$update['id_tb_provinsi'] = $this->input->post('id_tb_provinsi');
		$update['id_tb_kabupaten'] = $this->input->post('id_tb_kabupaten');
		$update['id_tb_kecamatan'] = $this->input->post('id_tb_kecamatan');
		$update['id_tb_kelurahan'] = $this->input->post('id_tb_kelurahan');
		$stmt = $this->M_api->profil_ubah($where,$update);
		if ($stmt){
			array_push($result,array('status'=>1));
		} else {
			array_push($result,array('status'=>0));
		}
		$this->setJSON(array('result'=>$result));
	}

	public function profil_password()
	{
		$result = array();
		$where['id_tb_pengguna'] = $this->input->post('id_tb_pengguna');
		$password_lama = $this->input->post('password_lama');
		$dt = $this->M_api->signin($where)->row();
		if ($dt->password == md5($password_lama)) {
			$update['password'] = md5($this->input->post('password_baru'));
			$stmt = $this->M_api->profil_ubah($where,$update);
			if ($stmt){
				array_push($result,array('status'=>1));
			} else {
				array_push($result,array('status'=>0));
			}
		} else {
			array_push($result,array('status'=>2));
		}
		$this->setJSON(array('result'=>$result));
	}

	public function provinsi()
	{
		$stmt = $this->M_api->provinsi();
		$response = array('result' => $stmt->result());
		$this->setJSON($response);
	}

	public function kabkota()
	{
		$stmt = $this->M_api->kabupaten(array('id_tb_provinsi'=>$this->input->post('id_tb_provinsi')));
		$response = array('result' => $stmt->result());
		$this->setJSON($response);
	}

	public function kecamatan()
	{
		$stmt = $this->M_api->kecamatan(array('id_tb_kabupaten'=>$this->input->post('id_tb_kabupaten')));
		$response = array('result' => $stmt->result());
		$this->setJSON($response);
	}

	public function kelurahan()
	{
		$stmt = $this->M_api->kelurahan(array('id_tb_kecamatan'=>$this->input->post('id_tb_kecamatan')));
		$response = array('result' => $stmt->result());
		$this->setJSON($response);
	}

	public function setJSON($response)
	{
		$this->output
			->set_status_header(200)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($response, JSON_PRETTY_PRINT))
			->_display();
		exit;
	}
}
