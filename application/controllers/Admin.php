<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('template');
		if (isset($this->session->userdata['login_admin']) != TRUE) {
			redirect(base_url());
		}
		$this->load->model('M_admin');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index()
	{
		$this->template->template_admin('admin/index');
	}

	public function pengguna()
	{
		$data['dt'] = $this->M_admin->pengguna_daftar()->result();
		$this->template->template_admin('admin/pengguna',$data);
	}

	public function pengguna_tambah()
	{
		$this->template->template_admin('admin/pengguna_tambah');
	}

	public function pengguna_tambah_execute(){
		$where['username'] = $this->input->post('username');
		$where['del_flage'] = 1;
		$cek = $this->M_admin->pengguna_detail($where);
		if ($cek->num_rows() > 0){
			$this->session->set_flashdata('info', '<div class="alert alert-danger alert-dismissable">Username sudah ada</div>');
			redirect(base_url('Admin/pengguna_tambah'));
		} else {
			$input['nama'] = $this->input->post('nama');
			$input['username'] = $this->input->post('username');
			$input['password'] = md5($this->input->post('password'));
			$input['jenis_kelamin'] = $this->input->post('jenis_kelamin');
			$input['create_date'] = date('Y-m-d H:i:s');
			$stmt = $this->M_admin->pengguna_tambah($input);
			if ($stmt){
				$this->session->set_flashdata('info', '<div class="alert alert-success alert-dismissable">Berhasil Menambahkan Data</div>');
				redirect(base_url('Admin/pengguna'));
			} else{
				$this->session->set_flashdata('info', '<div class="alert alert-danger alert-dismissable">Gagal Menambahkan Data</div>');
				redirect(base_url('Admin/pengguna_tambah'));
			}
		}
	}

	public function pengguna_edit()
	{
		$where['id_tb_pengguna'] = $this->uri->segment(3);
		$data['dt'] = $this->M_admin->pengguna_detail($where)->row();
		$this->template->template_admin('admin/pengguna_edit',$data);
	}

	public function pengguna_edit_execute(){
		$id =  $this->input->post('id');
		$where['id_tb_pengguna'] = $id;
		$update['nama'] = $this->input->post('nama');
		$update['username'] = $this->input->post('username');
		$update['jenis_kelamin'] = $this->input->post('jenis_kelamin');
		$update['update_date'] = date('Y-m-d H:i:s');
		$stmt = $this->M_admin->pengguna_update($where,$update);
		if ($stmt){
			$this->session->set_flashdata('info', '<div class="alert alert-success alert-dismissable">Berhasil Mengubah Data</div>');
			redirect(base_url('Admin/pengguna_detail/'.$id));
		} else{
			$this->session->set_flashdata('info', '<div class="alert alert-danger alert-dismissable">Gagal Mengubah Data</div>');
			redirect(base_url('Admin/pengguna_edit/'.$id));
		}
	}

	public function pengguna_reset_execute(){
		$id =  $this->uri->segment(3);
		$where['id_tb_pengguna'] = $id;
		$ck = $this->M_admin->pengguna_detail($where)->row();

		$update['password'] = md5($ck->username);
		$update['update_date'] = date('Y-m-d H:i:s');
		$stmt = $this->M_admin->pengguna_update($where,$update);
		if ($stmt){
			$this->session->set_flashdata('info', '<div class="alert alert-success alert-dismissable">Berhasil Mengubah Data. Password anda sesuai username anda adalah '.$ck->username.'</div>');
			redirect(base_url('Admin/pengguna_detail/'.$id));
		} else{
			$this->session->set_flashdata('info', '<div class="alert alert-danger alert-dismissable">Gagal Mengubah Data</div>');
			redirect(base_url('Admin/pengguna_edit/'.$id));
		}
	}

	public function pengguna_detail()
	{
		$where['id_tb_pengguna'] = $this->uri->segment(3);
		$data['dt'] = $this->M_admin->pengguna_detail($where)->row();
		$this->template->template_admin('admin/pengguna_detail',$data);
	}

	public function pengguna_hapus_execute(){
		$where['id_tb_pengguna'] = $this->uri->segment(3);
		$update['del_flage'] = 0;
		$update['delete_date'] = date('Y-m-d H:i:s');
		$stmt = $this->M_admin->pengguna_update($where,$update);
		if ($stmt){
			$this->session->set_flashdata('info', '<div class="alert alert-success alert-dismissable">Berhasil Menghapus Data</div>');
			redirect(base_url('Admin/pengguna'));
		} else{
			$this->session->set_flashdata('info', '<div class="alert alert-danger alert-dismissable">Gagal v Data</div>');
			redirect(base_url('Admin/pengguna'));
		}
	}

	public function kategori()
	{
		$data['dt'] = $this->M_admin->kategori_daftar()->result();
		$this->template->template_admin('admin/kategori',$data);
	}

	public function kategori_tambah()
	{
		$this->template->template_admin('admin/kategori_tambah');
	}

	public function kategori_tambah_execute(){
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
			$input['foto_kategori']	= $nama_foto;
			$input['create_date'] = date('Y-m-d H:i:s');
			$stmt = $this->M_admin->kategori_tambah($input);
			if ($stmt){
				$this->session->set_flashdata('info', '<div class="alert alert-success alert-dismissable">Berhasil Menambahkan Data</div>');
				redirect(base_url('Admin/kategori'));
			} else{
				$this->session->set_flashdata('info', '<div class="alert alert-danger alert-dismissable">Gagal Menambahkan Data</div>');
				redirect(base_url('Admin/kategori_tambah'));
			}
		} else{
			$this->session->set_flashdata('info', '<div class="alert alert-danger alert-dismissable">Gagal Mengunggah Foto</div>');
			redirect(base_url('Admin/kategori_tambah'));
		}
	}

	public function kategori_edit()
	{
		$where['tb_kacamata.id_tb_kategori'] = $this->uri->segment(3);
		$data['dt'] = $this->M_admin->kategori_detail($where)->row();
		$this->template->template_admin('admin/kategori_edit',$data);
	}

	public function kategori_edit_execute(){
		$id =  $this->input->post('id');
		$where['id_tb_kategori'] = $id;
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
		$stmt = $this->M_admin->kategori_update($where,$update);
		if ($stmt){
			$this->session->set_flashdata('info', '<div class="alert alert-success alert-dismissable">Berhasil Mengubah Data</div>');
			redirect(base_url('Admin/kategori_detail/'.$id));
		} else{
			$this->session->set_flashdata('info', '<div class="alert alert-danger alert-dismissable">Gagal Mengubah Data</div>');
			redirect(base_url('Admin/kategori_edit/'.$id));
		}
	}

	public function kategori_detail()
	{
		$where['tb_kacamata.id_tb_kategori'] = $this->uri->segment(3);
		$data['dt'] = $this->M_admin->kategori_detail($where)->row();
		$this->template->template_admin('admin/kategori_detail',$data);
	}

	public function kategori_hapus_execute(){
		$where['id_tb_kategori'] = $this->uri->segment(3);
		$update['del_flage'] = 0;
		$update['delete_date'] = date('Y-m-d H:i:s');
		$stmt = $this->M_admin->kategori_update($where,$update);
		if ($stmt){
			$this->session->set_flashdata('info', '<div class="alert alert-success alert-dismissable">Berhasil Menghapus Data</div>');
			redirect(base_url('Admin/kategori'));
		} else{
			$this->session->set_flashdata('info', '<div class="alert alert-danger alert-dismissable">Gagal v Data</div>');
			redirect(base_url('Admin/kategori'));
		}
	}

	public function kacamata()
	{
		$data['dt'] = $this->M_admin->kacamata_daftar()->result();
		$this->template->template_admin('admin/kacamata',$data);
	}

	public function kacamata_tambah()
	{
		$data['kategori'] = $this->M_admin->kategori_daftar()->result();
		$this->template->template_admin('admin/kacamata_tambah',$data);
	}

	public function kacamata_tambah_execute(){
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

			$input['id_tb_kategori'] = $this->input->post('kategori_kacamata');
			$input['nama_kacamata'] = $this->input->post('nama_kacamata');
			$input['harga_kacamata'] = $this->input->post('harga_kacamata');
			$input['deskripsi_kacamata'] = $this->input->post('deskripsi_kacamata');
			$input['foto_kacamata']	= $nama_foto;
			$input['create_date'] = date('Y-m-d H:i:s');
			$stmt = $this->M_admin->kacamata_tambah($input);
			if ($stmt){
				$this->session->set_flashdata('info', '<div class="alert alert-success alert-dismissable">Berhasil Menambahkan Data</div>');
				redirect(base_url('Admin/kacamata'));
			} else{
				$this->session->set_flashdata('info', '<div class="alert alert-danger alert-dismissable">Gagal Menambahkan Data</div>');
				redirect(base_url('Admin/kacamata_tambah'));
			}
		} else{
			$this->session->set_flashdata('info', '<div class="alert alert-danger alert-dismissable">Gagal Mengunggah Foto</div>');
			redirect(base_url('Admin/kacamata_tambah'));
		}
	}

	public function kacamata_edit()
	{
		$where['tb_kacamata.id_tb_kacamata'] = $this->uri->segment(3);
		$data['dt'] = $this->M_admin->kacamata_detail($where)->row();
		$data['kategori'] = $this->M_admin->kategori_daftar()->result();
		$this->template->template_admin('admin/kacamata_edit',$data);
	}

	public function kacamata_edit_execute(){
		$id =  $this->input->post('id');
		$where['id_tb_kacamata'] = $id;
		$update['id_tb_kategori'] = $this->input->post('nama_kategori');
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
		$stmt = $this->M_admin->kacamata_update($where,$update);
		if ($stmt){
			$this->session->set_flashdata('info', '<div class="alert alert-success alert-dismissable">Berhasil Mengubah Data</div>');
			redirect(base_url('Admin/kacamata_detail/'.$id));
		} else{
			$this->session->set_flashdata('info', '<div class="alert alert-danger alert-dismissable">Gagal Mengubah Data</div>');
			redirect(base_url('Admin/kacamata_edit/'.$id));
		}
	}

	public function kacamata_detail()
	{
		$where['id_tb_kacamata'] = $this->uri->segment(3);
		$data['dt'] = $this->M_admin->kacamata_detail($where)->row();
		$this->template->template_admin('admin/kacamata_detail',$data);
	}

	public function kacamata_hapus_execute(){
		$where['id_tb_kacamata'] = $this->uri->segment(3);
		$update['del_flage'] = 0;
		$update['delete_date'] = date('Y-m-d H:i:s');
		$stmt = $this->M_admin->kacamata_update($where,$update);
		if ($stmt){
			$this->session->set_flashdata('info', '<div class="alert alert-success alert-dismissable">Berhasil Menghapus Data</div>');
			redirect(base_url('Admin/kacamata'));
		} else{
			$this->session->set_flashdata('info', '<div class="alert alert-danger alert-dismissable">Gagal v Data</div>');
			redirect(base_url('Admin/kacamata'));
		}
	}

	public function pembelian(){
		$this->template->template_admin('admin/pembelian');
	}

	public function grafik(){
		$this->template->template_admin('admin/laporan');
	}

	public function profil(){
		$this->template->template_admin('admin/profil');
	}

	function log_out(){
		$this->session->sess_destroy();
		redirect(base_url());
	}
}
