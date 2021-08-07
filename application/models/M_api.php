<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_api extends CI_Model {

	public function signup($input)
	{
		$this->db->insert("tb_pengguna",$input);
		return $this->db->insert_id();
	}

	public function signin($where)
	{
		return $this->db->select('tb_pengguna.*, tb_provinsi.nama_provinsi, tb_kabupaten.nama_kabupaten, tb_kecamatan.nama_kecamatan, tb_kelurahan.nama_kelurahan')
			->join('tb_provinsi','tb_provinsi.id_tb_provinsi = tb_pengguna.id_tb_provinsi')
			->join('tb_kabupaten','tb_kabupaten.id_tb_kabupaten = tb_pengguna.id_tb_kabupaten')
			->join('tb_kecamatan','tb_kecamatan.id_tb_kecamatan = tb_pengguna.id_tb_kecamatan')
			->join('tb_kelurahan','tb_kelurahan.id_tb_kelurahan = tb_pengguna.id_tb_kelurahan')
			->get_where("tb_pengguna",$where);
	}

	public function profil_ubah($where,$update)
	{
		return $this->db->where($where)->update('tb_pengguna', $update);
	}

	public function kacamata_terbaru()
	{
		return $this->db->limit(10)->order_by('id_tb_kacamata',"DESC")
			->get_where('tb_kacamata',array('del_flage'=>1));
	}

	public function kacamata($where){
		return $this->db->select('tb_kacamata.*,tb_kategori.nama_kategori')
			->join('tb_kategori','tb_kategori.id_tb_kategori = tb_kacamata.id_tb_kategori')
			->order_by('tb_kacamata.id_tb_kacamata',"DESC")
			->get_where('tb_kacamata',$where);
	}

	public function kategori()
	{
		return $this->db->order_by('id_tb_kategori',"DESC")
			->get_where('tb_kategori',array('del_flage'=>1));
	}

	public function kacamata_detail($where){
		return $this->db->select('tb_kacamata.*,tb_kategori.nama_kategori')
			->join('tb_kategori','tb_kategori.id_tb_kategori = tb_kacamata.id_tb_kategori')
			->get_where('tb_kacamata',$where);
	}

	public function kacamata_favorit($where)
	{
		return $this->db->select('tb_kacamata_favorit.*, tb_kacamata.nama_kacamata, tb_kacamata.deskripsi_kacamata, tb_kacamata.harga_kacamata, tb_kacamata.foto_kacamata, tb_kacamata.file_3d, tb_kategori.nama_kategori')
		->join('tb_kacamata','tb_kacamata.id_tb_kacamata = tb_kacamata_favorit.id_tb_kacamata')
		->join('tb_kategori','tb_kategori.id_tb_kategori = tb_kacamata.id_tb_kategori')
		->order_by('tb_kacamata_favorit.create_date','DESC')
		->get_where('tb_kacamata_favorit',$where);
	}

	public function kacamata_favorit_update($where,$update)
	{
		return $this->db->where($where)->update('tb_kacamata_favorit',$update);
	}

	public function kacamata_favorit_tambah($input)
	{
		return $this->db->insert('tb_kacamata_favorit',$input);
	}

	public function provinsi()
	{
		return $this->db->get("tb_provinsi");
	}

	public function kabupaten($where)
	{
		return $this->db->get_where("tb_kabupaten",$where);
	}

	public function kecamatan($where)
	{
		return $this->db->get_where("tb_kecamatan",$where);
	}

	public function kelurahan($where)
	{
		return $this->db->get_where("tb_kelurahan",$where);
	}
}
