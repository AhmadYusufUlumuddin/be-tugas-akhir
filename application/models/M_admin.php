<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_admin extends CI_Model {

	public function pengguna_daftar()
	{
		return $this->db->where(array('del_flage'=>1))->order_by('id_tb_pengguna','DESC')->get('tb_pengguna');
	}
	public function pengguna_tambah($input)
	{
		return $this->db->insert('tb_pengguna',$input);
	}
	public function pengguna_detail($where)
	{
		return $this->db->where($where)->get('tb_pengguna');
	}
	public function pengguna_update($where,$update)
	{
		return $this->db->where($where)->update('tb_pengguna',$update);
	}
	public function kategori_daftar()
	{
		return $this->db->where(array('del_flage'=>1))->order_by('id_tb_kategori','DESC')->get('tb_kategori');
	}
	public function kategori_tambah($input)
	{
		return $this->db->insert('tb_kategori',$input);
	}
	public function kategori_detail($where)
	{
		return $this->db->where($where)->get('tb_kategori');
	}
	public function kategori_update($where,$update)
	{
		return $this->db->where($where)->update('tb_kategori',$update);
	}
	public function kacamata_daftar()
	{
		return $this->db->select('tb_kacamata.*, tb_kategori.nama_kategori')
			->join('tb_kategori','tb_kategori.id_tb_kategori = tb_kacamata.id_tb_kategori')
			->where(array('tb_kacamata.del_flage'=>1))->order_by('tb_kacamata.id_tb_kacamata','DESC')->get('tb_kacamata');
	}
	public function kacamata_tambah($input)
	{
		return $this->db->insert('tb_kacamata',$input);
	}
	public function kacamata_detail($where)
	{
		return $this->db->select('tb_kacamata.*, tb_kategori.nama_kategori')
			->join('tb_kategori','tb_kategori.id_tb_kategori = tb_kacamata.id_tb_kategori')
			->where($where)->get('tb_kacamata');
	}
	public function kacamata_update($where,$update)
	{
		return $this->db->where($where)->update('tb_kacamata',$update);
	}

}
