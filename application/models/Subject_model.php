<?php
class Subject_model extends CI_Model {

	// Get data
	public function listData($data = array()){
		$this->db->select($data['fide']);
		if(!empty($data['where'])){$this->db->where($data['where']);}
		if(!empty($data['orderby'])){$this->db->order_by($data['orderby']);}
		if(!empty($data['limit'])){$this->db->limit($data['limit'][0],$data['limit'][1]);}
		$query = $this->db->get('tb_subject');
		return $query->result_array();
	}
	
	public function listjoinData($data = array()){
        $this->db->select($data['fide']);
        $this->db->from('tb_subject');
		$this->db->join('tb_user', 'tb_user.use_id = tb_subject.use_id');
		$this->db->join('tb_settings', 'tb_settings.set_id = tb_subject.set_id');
		if(!empty($data['where'])){$this->db->where($data['where']);}
		if(!empty($data['orderby'])){$this->db->order_by($data['orderby']);}
		if(!empty($data['limit'])){$this->db->limit($data['limit'][0],$data['limit'][1]);}
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function listjoinData2($data = array()){
        $this->db->select($data['fide']);
        $this->db->from('tb_subject');
		$this->db->join('tb_user', 'tb_subject.use_id = tb_user.use_id');
		$this->db->join('tb_student', 'tb_subject.sub_id = tb_student.sub_id');
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

    // Insert data
	public function insertData($data = array()){
		$this->db->insert("tb_subject",$data);
		return $this->db->insert_id();
	}
	public function updateData($data = array()){
		$this->db->where(array('sub_id' => $data['sub_id']));
		$this->db->update("tb_subject",$data);
		return $data['sub_id'];
	}
	public function deleteData($data = array()){
		$this->db->delete('tb_subject', array('sub_id' => $data['sub_id']));
	}
}