<?php
class Emailset_model extends CI_Model {

	// Get data
	public function listData($data = array()){
		$this->db->select($data['fide']);
		if(!empty($data['where'])){$this->db->where($data['where']);}
		if(!empty($data['orderby'])){$this->db->order_by($data['orderby']);}
		if(!empty($data['limit'])){$this->db->limit($data['limit'][0],$data['limit'][1]);}
		$query = $this->db->get('tb_emailset');
		return $query->result_array();
	}

    // Insert data
	public function insertData($data = array()){
		$this->db->insert("tb_emailset",$data);
		return $this->db->insert_id();
	}
	public function updateData($data = array()){
		$this->db->where(array('email_id' => $data['email_id']));
		$this->db->update("tb_emailset",$data);
		return $data['email_id'];
	}

	public function setData($data = array()){
		$this->db->update("tb_emailset", array('email_status' => 0));

		$this->db->where(array('email_id' => $data['email_id']));
		$this->db->update("tb_emailset",array('email_status' => 1));
		return $data['email_id'];
	}
	public function deleteData($data = array()){
		$this->db->delete('tb_emailset', array('email_id' => $data['email_id']));
	}
}