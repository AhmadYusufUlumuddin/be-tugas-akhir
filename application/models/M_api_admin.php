<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_api_admin extends CI_Model {


	public function signin($where)
	{
		return $this->db->get_where("tb_admin",$where);
	}

	public function profil_edit($where,$update)
	{
		return $this->db->where($where)->update('tb_admin', $update);
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

	public function kategori_detail($where)
	{
		return $this->db->get_where('tb_kategori',$where);
	}

	public function kategori_edit($where,$update)
	{
		return $this->db->where($where)->update('tb_kategori', $update);
	}

	public function kategori_tambah($input)
	{
		return $this->db->insert('tb_kategori', $input);
	}

	public function kacamata_detail($where){
		return $this->db->select('tb_kacamata.*,tb_kategori.nama_kategori')
			->join('tb_kategori','tb_kategori.id_tb_kategori = tb_kacamata.id_tb_kategori')
			->get_where('tb_kacamata',$where);
	}

	public function kacamata_edit($where,$update)
	{
		return $this->db->where($where)->update('tb_kacamata', $update);
	}

	public function kacamata_tambah($input)
	{
		return $this->db->insert('tb_kacamata', $input);
	}

	public function pengguna($where)
	{
		return $this->db->order_by('id_tb_pengguna',"DESC")->get_where('tb_pengguna', $where);
	}
}
