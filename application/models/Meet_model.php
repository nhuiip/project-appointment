<?php
class Meet_model extends CI_Model {

	// Get data
	public function listData($data = array()){
		$this->db->select($data['fide']);
		if(!empty($data['where'])){$this->db->where($data['where']);}
		if(!empty($data['orderby'])){$this->db->order_by($data['orderby']);}
		// if(!empty($data['groupby'])){$this->db->group_by($data['groupby']);}
		if(!empty($data['limit'])){$this->db->limit($data['limit'][0],$data['limit'][1]);}
		$query = $this->db->get('tb_meet');
		return $query->result_array();
	}
	
	public function listjoinData($data = array()){
		$this->db->select($data['fide']);
		$this->db->from('tb_meet');
		$this->db->join('tb_project', 'tb_project.project_id = tb_project.project_id');
		$this->db->join('tb_settings', 'tb_settings.set_id = tb_meet.set_id');
		if(!empty($data['where'])){$this->db->where($data['where']);}
		if(!empty($data['orderby'])){$this->db->order_by($data['orderby']);}
		// if(!empty($data['groupby'])){$this->db->group_by($data['groupby']);}
		if(!empty($data['limit'])){$this->db->limit($data['limit'][0],$data['limit'][1]);}
		$query = $this->db->get();
		return $query->result_array();
	}
	
    // Insert data
	public function insertData($data = array()){
		$this->db->insert("tb_meet",$data);
		return $this->db->insert_id();
	}
	public function updateData($data = array()){
		$this->db->where(array('sec_id' => $data['sec_id']));
		$this->db->update("tb_meet",$data);
		return $data['sec_id'];
	}
}