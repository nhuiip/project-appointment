<?php
class Student_model extends CI_Model {

	// Get data
	public function listData($data = array()){
		$this->db->select($data['fide']);
		if(!empty($data['where'])){$this->db->where($data['where']);}
		if(!empty($data['orderby'])){$this->db->order_by($data['orderby']);}
		if(!empty($data['limit'])){$this->db->limit($data['limit'][0],$data['limit'][1]);}
		$query = $this->db->get('tb_student');
		return $query->result_array();
	}
	
	public function listjoinData($data = array()){
        $this->db->select($data['fide']);
        $this->db->from('tb_student');
		$this->db->join('tb_position', 'tb_position.position_id = tb_student.position_id');
		$this->db->join('tb_subject', 'tb_subject.sub_id = tb_student.sub_id', 'left');
		if(!empty($data['where'])){$this->db->where($data['where']);}
		if(!empty($data['orderby'])){$this->db->order_by($data['orderby']);}
		if(!empty($data['limit'])){$this->db->limit($data['limit'][0],$data['limit'][1]);}
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function getrecordCount($search="") {

		$this->db->select('count(*) as allcount');
		$this->db->from('tb_student');
	
		if($search != ''){
			$this->db->like('std_number', $search);
		}

		$query = $this->db->get();
		$result = $query->result_array();
	
		return $result[0]['allcount'];
	}

	public function getData($rowno,$rowperpage,$search="") {
 
		$this->db->select('*');
		$this->db->from('tb_student');
	
		if($search != ''){
		  $this->db->like('std_number', $search);
		}
	
		$this->db->limit($rowperpage, $rowno); 
		$query = $this->db->get();
	 
		return $query->result_array();
	  }

    // Insert data
	public function insertData($data = array()){
		$this->db->insert("tb_student",$data);
		return $this->db->insert_id();
	}
	public function updateData($data = array()){
		$this->db->where(array('std_id' => $data['std_id']));
		$this->db->update("tb_student",$data);
		return $data['std_id'];
	}

	public function updateStd($data = array()){
		$this->db->where(array('std_id' => $data['std_id']));
		$this->db->update("tb_student",$data);
		return $data['std_id'];
	}

}