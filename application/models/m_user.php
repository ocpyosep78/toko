<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_user extends CI_Model{

	function __construct() {
		parent::__construct();
	}
	public function cek_login($un,$pass)
	{
		$query=$this->db->get_where('user',
			array(
				'username'=>$un,
				'password'=>sha1($pass)
				)
			,1);
		if($query->num_rows()==1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function update($id,$data)
	{
		$this->db->where('id',$id);
		$this->db->update('user',$data);
	}
	function tambahuser($data)
	{
		$this->db->insert('user',$data);
	}
	function get_jabatan($idj){
		$query=$this->db->get_where("jabatan",array("kdcapab"=>$idj),1);
		if ($query->num_rows()===0) {
			return false;
		}else{
			foreach ($query->result() as $row){
				if ($row->jabatan!==0) {
					return $row->jabatan;
				}else{
					return false;
				}
			}
		}
	}
	public function cek_email($un,$email)
	{
		$query=$this->db->get_where('user',
			array(
				'username'=>$un,
				'email'=>$email
				)
			,1);
		if($query->num_rows()==1){
			return $query->result_array();
		}else{
			return FALSE;
		}
	}
	public function getmaxuser()
	{
		$this->db->select_max('id');
		$query = $this->db->get('user');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $value) {
				return $value->id;
			}
		}else{
			return false;
		}
	}
}