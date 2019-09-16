<?php
class Administrator_model extends CI_Model {

	// Get data
	public function listData($data = array()){
		$this->db->select($data['fide']);
		if(!empty($data['where'])){$this->db->where($data['where']);}
		if(!empty($data['where_in'])){
			$this->db->where_in($data['where_in']['filde'],$data['where_in']['value']);
		}
		if(!empty($data['orderby'])){$this->db->order_by($data['orderby']);}
		if(!empty($data['limit'])){$this->db->limit($data['limit'][0],$data['limit'][1]);}
		$query = $this->db->get('tb_user');
		return $query->result_array();
	}

	// Get full join table
	public function listDataFull($data = array()){
		$this->db->select($data['fide']);
		$this->db->from('tb_user');
		$this->db->join('tb_position', 'tb_user.position_id = tb_position.position_id');
		if(!empty($data['where'])){$this->db->where($data['where']);}
		if(!empty($data['orderby'])){$this->db->order_by($data['orderby']);}
		if(!empty($data['limit'])){$this->db->limit($data['limit'][0],$data['limit'][1]);}
		$query = $this->db->get();
		return $query->result_array();
	}

	public function liststdFull($data = array()){
		$this->db->select($data['fide']);
		$this->db->from('tb_student');
		$this->db->join('tb_position', 'tb_student.position_id = tb_position.position_id');
		if(!empty($data['where'])){$this->db->where($data['where']);}
		if(!empty($data['orderby'])){$this->db->order_by($data['orderby']);}
		if(!empty($data['limit'])){$this->db->limit($data['limit'][0],$data['limit'][1]);}
		$query = $this->db->get();
		return $query->result_array();
	}

	// Get data position
	public function listDataPosition($data = array()){
		$this->db->select($data['fide']);
		if(!empty($data['where'])){$this->db->where($data['where']);}
		if(!empty($data['orderby'])){$this->db->order_by($data['orderby']);}
		if(!empty($data['limit'])){$this->db->limit($data['limit'][0],$data['limit'][1]);}
		$query = $this->db->get('tb_position');
		return $query->result_array();
	}

	// Insert data
	public function insertData($data = array()){
		//$this->db->db_debug = FALSE;
		$this->db->insert("tb_user",$data);
		return $this->db->insert_id();
	}

	// Update data or delete data (status 0 = deactive 1 = active)
	public function updateData($data = array()){
		$this->db->where(array('use_id' => $data['use_id']));
		$this->db->update("tb_user",$data);
		return $data['use_id'];
	}

	public function updateStd($data = array()){
		$this->db->where(array('std_id' => $data['std_id']));
		$this->db->update("tb_student",$data);
		return $data['std_id'];
	}

}
?>
