<?php
class Project_model extends CI_Model {

	// Get data
	public function listData($data = array()){
		$this->db->select($data['fide']);
		if(!empty($data['where'])){$this->db->where($data['where']);}
		if(!empty($data['orderby'])){$this->db->order_by($data['orderby']);}
		if(!empty($data['limit'])){$this->db->limit($data['limit'][0],$data['limit'][1]);}
		$query = $this->db->get('tb_project');
		return $query->result_array();
	}
	
	public function listjoinData($data = array()){
        $this->db->select($data['fide']);
        $this->db->from('tb_project');
		$this->db->join('tb_user', 'tb_user.use_id = tb_project.use_id');
		if(!empty($data['where'])){$this->db->where($data['where']);}
		if(!empty($data['orderby'])){$this->db->order_by($data['orderby']);}
		if(!empty($data['limit'])){$this->db->limit($data['limit'][0],$data['limit'][1]);}
		$query = $this->db->get();
		return $query->result_array();
	}

	public function searchstdProject($Id){
		$this->db->select('*');
		$this->db->like('std_id',$Id);
		$query = $this->db->get('tb_project');
		return $query->result_array();
	}

	public function searchnameProject($Nameproject){
		$this->db->select('*');
		$this->db->like('project_name',$Nameproject);
		$query = $this->db->get('tb_project');
		return $query->result_array();
	}

    // Insert data
	public function insertData($data = array()){
		$this->db->insert("tb_project",$data);
		return $this->db->insert_id();
	}
	public function updateData($data = array()){
		$this->db->where(array('project_id' => $data['project_id']));
		$this->db->update("tb_project",$data);
		return $data['project_id'];
	}
	public function deleteData($data = array()){
		$this->db->delete('tb_project', array('project_id' => $data['project_id']));
	}
}