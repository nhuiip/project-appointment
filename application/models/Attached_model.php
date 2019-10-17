<?php
class Attached_model extends CI_Model {

	// Get data
	public function listData($data = array()){
		$this->db->select($data['fide']);
		if(!empty($data['where'])){$this->db->where($data['where']);}
		if(!empty($data['orderby'])){$this->db->order_by($data['orderby']);}
		if(!empty($data['groupby'])){$this->db->group_by($data['groupby']);}
		if(!empty($data['limit'])){$this->db->limit($data['limit'][0],$data['limit'][1]);}
		$query = $this->db->get('tb_attached');
		return $query->result_array();
	}
	
	public function listjoinData($data = array()){
		$this->db->select($data['fide']);
		$this->db->from('tb_attached');
		$this->db->join('tb_subject', 'tb_subject.sub_id = tb_attached.sub_id');
		if(!empty($data['where'])){$this->db->where($data['where']);}
		if(!empty($data['orderby'])){$this->db->order_by($data['orderby']);}
		if(!empty($data['groupby'])){$this->db->group_by($data['groupby']);}
		if(!empty($data['limit'])){$this->db->limit($data['limit'][0],$data['limit'][1]);}
		$query = $this->db->get();
		return $query->result_array();
	}
	
    // Insert data
	public function insertData($data = array()){
		$this->db->insert("tb_attached",$data);
		return $this->db->insert_id();
	}
	public function updateData($data = array()){
		$this->db->where(array('att_id' => $data['att_id']));
		$this->db->update("tb_attached",$data);
		return $data['att_id'];
	}

	public function deleteData($data = array()){
		$this->db->delete('tb_attached', array('att_id' => $data['att_id']));
	}
}