<?php
class Holiday_model extends CI_Model {

	// Get data
	public function listData($data = array()){
		$this->db->select($data['fide']);
		if(!empty($data['where'])){$this->db->where($data['where']);}
		if(!empty($data['orderby'])){$this->db->order_by($data['orderby']);}
		if(!empty($data['limit'])){$this->db->limit($data['limit'][0],$data['limit'][1]);}
		$query = $this->db->get('tb_holiday');
		return $query->result_array();
    }
    // Insert data
	public function insertData($data = array()){
		$this->db->insert("tb_holiday",$data);
		return $this->db->insert_id();
    }
    public function updateData($data = array()){
		$this->db->where(array('hol_id' => $data['hol_id']));
		$this->db->update("tb_holiday",$data);
		return $data['hol_id'];
	}
    public function deleteData($data = array()){
		$this->db->delete('tb_holiday', array('hol_id' => $data['hol_id']));
	}
}