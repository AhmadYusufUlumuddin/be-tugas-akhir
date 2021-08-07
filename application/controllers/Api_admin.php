<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_admin extends CI_Controller {

	public $result = array();

	function __construct()
	{
		parent::__construct();
		$this->load->model('M_api_admin');
		date_default_timezone_set('Asia/Jakarta');
	}


	public function signin()
	{
		$result = array();
		$where['username'] = $this->input->post('username');
		$where['password'] = md5($this->input->post('password'));
		$stmt = $this->M_api_admin->signin($where);
		if ($stmt->num_rows() > 0) {
			$dt = $stmt->row();
			$data = array(
				'status'=>"1",
				'id_tb_admin'=>$dt->id_tb_admin,
				'username'=>$dt->username
			);
			array_push($result,$data);
		} else {
			array_push($result,array('status'=>"0"));
		}
        $this->setJSON(array('result'=>$result));
		
	}

	public function home()
	{
		$stmt = $this->M_api_admin->kacamata_terbaru();
		$stmt2 = $this->M_api_admin->kategori();
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
		$stmt = $this->M_api_admin->kacamata($where);
		$response = array('result' => $stmt->result());
		$this->setJSON($response);
	}

	public function kacamata_tambah()
	{
		$result = array();
		$uploadPath = './assets/upload/kacamata/';
		$config['upload_path'] = $uploadPath;
		$config['allowed_types'] = '*';
		$config['file_name'] = date('ymdHis');

		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if($this->upload->do_upload('foto')){
			$fileData = $this->upload->data();
			$nama_foto = $fileData['file_name'];
			$tipe = $fileData['file_type'];
			if ($tipe == "image/jpeg" || $tipe == "image/png" || $tipe == "image/jpg") {
				$image_data = $this->upload->data();
				$config['image_library'] = 'gd2';
				$config['source_image'] = $image_data['full_path'];
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 822;
				$this->load->library('image_lib');
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				$this->image_lib->clear();
			}

			$uploadPath2 = './assets/upload/3d/';
			$config2['upload_path'] = $uploadPath2;
			$config2['allowed_types'] = '*';
			$config2['file_name'] = date('ymdHis');

			$this->load->library('upload', $config2);
			$this->upload->initialize($config2);
			if($this->upload->do_upload('file')) {
				$fileData2 = $this->upload->data();
				$nama_file = $fileData2['file_name'];

				$input['file_3d'] = $nama_file;
			}

			$input['id_tb_kategori'] = $this->input->post('id_tb_kategori');
			$input['nama_kacamata'] = $this->input->post('nama_kacamata');
			$input['harga_kacamata'] = $this->input->post('harga_kacamata');
			$input['deskripsi_kacamata'] = $this->input->post('deskripsi_kacamata');
			$input['foto_kacamata'] = $nama_foto;
			$input['create_date'] = date('Y-m-d H:i:s');
			$stmt = $this->M_api_admin->kacamata_tambah($input);
			if ($stmt){
				array_push($result,array('status'=>1));
			} else {
				array_push($result,array('status'=>0));
			}
		} else {
			array_push($result,array('status'=>0));
		}
		
		$this->setJSON(array('result'=>$result));
	}

	public function kacamata_detail(){
		$where['tb_kacamata.id_tb_kacamata'] = $this->input->post('id_tb_kacamata');
		$stmt = $this->M_api_admin->kacamata_detail($where);
		$response = array('result' => $stmt->result());
		$this->setJSON($response);
	}

	public function kacamata_edit()
	{
		$result = array();
		$where['id_tb_kacamata'] = $this->input->post('id_tb_kacamata');
		$update['id_tb_kategori'] = $this->input->post('id_tb_kategori');
		$update['nama_kacamata'] = $this->input->post('nama_kacamata');
		$update['harga_kacamata'] = $this->input->post('harga_kacamata');
		$update['deskripsi_kacamata'] = $this->input->post('deskripsi_kacamata');

		$uploadPath = './assets/upload/kacamata/';
		$config['upload_path'] = $uploadPath;
		$config['allowed_types'] = '*';
		$config['file_name'] = date('ymdHis');

		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if($this->upload->do_upload('foto')){
			$fileData = $this->upload->data();
			$nama_foto = $fileData['file_name'];
			$tipe = $fileData['file_type'];
			if ($tipe == "image/jpeg" || $tipe == "image/png" || $tipe == "image/jpg") {
				$image_data = $this->upload->data();
				$config['image_library'] = 'gd2';
				$config['source_image'] = $image_data['full_path'];
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 822;
				$this->load->library('image_lib');
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				$this->image_lib->clear();
			}

			$update['foto_kacamata'] = $nama_foto;
			$foto_lama = $this->input->post('foto_lama');
			if (file_exists($uploadPath.$foto_lama)) {
				unlink($uploadPath.$foto_lama);
			}
		}

		$uploadPath2 = './assets/upload/3d/';
		$config2['upload_path'] = $uploadPath2;
		$config2['allowed_types'] = '*';
		$config2['file_name'] = date('ymdHis');

		$this->load->library('upload', $config2);
		$this->upload->initialize($config2);
		if($this->upload->do_upload('file')) {
			$fileData2 = $this->upload->data();
			$nama_file = $fileData2['file_name'];

			$update['file_3d'] = $nama_file;
			$file_lama = $this->input->post('file_lama');
			if (file_exists($uploadPath2.$file_lama)) {
				unlink($uploadPath2.$file_lama);
			}
		}

		$update['update_date'] = date('Y-m-d H:i:s');
		$stmt = $this->M_api_admin->kacamata_edit($where,$update);
		if ($stmt){
			array_push($result,array('status'=>1));
		} else {
			array_push($result,array('status'=>0));
		}
		$this->setJSON(array('result'=>$result));
	}

	public function kacamata_hapus()
	{
		$result = array();
		$where['id_tb_kacamata'] = $this->input->post('id_tb_kacamata');
		$update['del_flage'] = 0;
		$update['delete_date'] = date('Y-m-d H:i:s');
		$stmt = $this->M_api_admin->kacamata_edit($where,$update);
		if ($stmt){
			array_push($result,array('status'=>1));
		} else {
			array_push($result,array('status'=>0));
		}
		$this->setJSON(array('result'=>$result));
	}

	public function profil_edit(){
		$result = array();
		$where['id_tb_admin'] = $this->input->post('id_tb_admin');
		$update['username'] = $this->input->post('username');
		$stmt = $this->M_api_admin->profil_edit($where,$update);
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
		$where['id_tb_admin'] = $this->input->post('id_tb_admin');
		$password_lama = $this->input->post('password_lama');
		$dt = $this->M_api_admin->signin($where)->row();
		if ($dt->password == md5($password_lama)) {
			$update['password'] = md5($this->input->post('password_baru'));
			$stmt = $this->M_api_admin->profil_edit($where,$update);
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

	public function pengguna(){
		$where['del_flage'] = 1;
		$stmt = $this->M_api_admin->pengguna($where);
		$response = array('result' => $stmt->result());
		$this->setJSON($response);
	}

	public function kategori(){
		$stmt = $this->M_api_admin->kategori();
		$response = array('result' => $stmt->result());
		$this->setJSON($response);
	}

	public function kategori_detail(){
		$where['id_tb_kategori'] = $this->input->post('id_tb_kategori');
		$stmt = $this->M_api_admin->kategori_detail($where);
		$response = array('result' => $stmt->result());
		$this->setJSON($response);
	}

	public function kategori_tambah()
	{
		$result = array();
		$uploadPath = './assets/upload/kategori/';
		$config['upload_path'] = $uploadPath;
		$config['allowed_types'] = '*';
		$config['file_name'] = date('ymdHis');

		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if($this->upload->do_upload('foto')){
			$fileData = $this->upload->data();
			$nama_foto = $fileData['file_name'];
			$tipe = $fileData['file_type'];
			if ($tipe == "image/jpeg" || $tipe == "image/png" || $tipe == "image/jpg") {
				$image_data = $this->upload->data();
				$config['image_library'] = 'gd2';
				$config['source_image'] = $image_data['full_path'];
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 822;
				$this->load->library('image_lib');
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				$this->image_lib->clear();
			}

			$input['nama_kategori'] = $this->input->post('nama_kategori');
			$input['foto_kategori'] = $nama_foto;
			$input['create_date'] = date('Y-m-d H:i:s');
			$stmt = $this->M_api_admin->kategori_tambah($input);
			if ($stmt){
				array_push($result,array('status'=>1));
			} else {
				array_push($result,array('status'=>0));
			}
		} else {
			array_push($result,array('status'=>0));
		}
		
		$this->setJSON(array('result'=>$result));
	}

	public function kategori_edit()
	{
		$result = array();
		$where['id_tb_kategori'] = $this->input->post('id_tb_kategori');
		$update['nama_kategori'] = $this->input->post('nama_kategori');

		$uploadPath = './assets/upload/kategori/';
		$config['upload_path'] = $uploadPath;
		$config['allowed_types'] = '*';
		$config['file_name'] = date('ymdHis');

		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if($this->upload->do_upload('foto')){
			$fileData = $this->upload->data();
			$nama_foto = $fileData['file_name'];
			$tipe = $fileData['file_type'];
			if ($tipe == "image/jpeg" || $tipe == "image/png" || $tipe == "image/jpg") {
				$image_data = $this->upload->data();
				$config['image_library'] = 'gd2';
				$config['source_image'] = $image_data['full_path'];
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 822;
				$this->load->library('image_lib');
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				$this->image_lib->clear();
			}

			$update['foto_kategori'] = $nama_foto;
			$foto_lama = $this->input->post('foto_lama');
			if (file_exists($uploadPath.$foto_lama)) {
				unlink($uploadPath.$foto_lama);
			}
		}

		$update['update_date'] = date('Y-m-d H:i:s');
		$stmt = $this->M_api_admin->kategori_edit($where,$update);
		if ($stmt){
			array_push($result,array('status'=>1));
		} else {
			array_push($result,array('status'=>0));
		}
		$this->setJSON(array('result'=>$result));
	}

	public function kategori_hapus()
	{
		$result = array();
		$where['id_tb_kategori'] = $this->input->post('id_tb_kategori');
		$update['del_flage'] = 0;
		$update['delete_date'] = date('Y-m-d H:i:s');
		$stmt = $this->M_api_admin->kategori_edit($where,$update);
		if ($stmt){
			array_push($result,array('status'=>1));
		} else {
			array_push($result,array('status'=>0));
		}
		$this->setJSON(array('result'=>$result));
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
