<?php
class Meet_model extends CI_Model {

	// Get data
	public function listData($data = array()){
		$this->db->select($data['fide']);
		if(!empty($data['where'])){$this->db->where($data['where']);}
		if(!empty($data['orderby'])){$this->db->order_by($data['orderby']);}
		if(!empty($data['limit'])){$this->db->limit($data['limit'][0],$data['limit'][1]);}
		$query = $this->db->get('tb_meet');
		return $query->result_array();
	}

	// Get data
	public function listDatadetail($data = array()){
		$this->db->select($data['fide']);
		if(!empty($data['where'])){$this->db->where($data['where']);}
		if(!empty($data['orderby'])){$this->db->order_by($data['orderby']);}
		if(!empty($data['limit'])){$this->db->limit($data['limit'][0],$data['limit'][1]);}
		$query = $this->db->get('tb_meetdetail');
		return $query->result_array();
	}
	
	public function listjoinData($data = array()){
		$this->db->select($data['fide']);
		$this->db->from('tb_meet');
		$this->db->join('tb_project', 'tb_project.project_id = tb_meet.project_id');
		$this->db->join('tb_settings', 'tb_settings.set_id = tb_meet.set_id');
		$this->db->join('tb_subject', 'tb_subject.sub_id = tb_meet.sub_id');
		if(!empty($data['where'])){$this->db->where($data['where']);}
		if(!empty($data['orderby'])){$this->db->order_by($data['orderby']);}
		if(!empty($data['limit'])){$this->db->limit($data['limit'][0],$data['limit'][1]);}
		$query = $this->db->get();
		return $query->result_array();
	}

	public function listjoinData2($data = array()){
		$this->db->select($data['fide']);
		$this->db->from('tb_meet');
		$this->db->join('tb_meetdetail', 'tb_meetdetail.meet_id = tb_meet.meet_id','left');
		$this->db->join('tb_settings', 'tb_settings.set_id = tb_meet.set_id');
		$this->db->join('tb_project', 'tb_project.project_id = tb_meet.project_id');
		$this->db->join('tb_user', 'tb_user.use_id = tb_meetdetail.use_id', 'left');
		if(!empty($data['where'])){$this->db->where($data['where']);}
		if(!empty($data['orderby'])){$this->db->order_by($data['orderby']);}
		if(!empty($data['limit'])){$this->db->limit($data['limit'][0],$data['limit'][1]);}
		$query = $this->db->get();
		return $query->result_array();
	}

	public function listjoinData3($data = array()){
		$this->db->select($data['fide']);
		$this->db->from('tb_meet');
		$this->db->join('tb_project', 'tb_project.project_id = tb_meet.project_id');
		$this->db->join('tb_settings', 'tb_settings.set_id = tb_meet.set_id');
		$this->db->join('tb_subject', 'tb_subject.sub_id = tb_meet.sub_id');
		$this->db->join('tb_user', 'tb_user.use_id = tb_subject.use_id');
		if(!empty($data['where'])){$this->db->where($data['where']);}
		if(!empty($data['orderby'])){$this->db->order_by($data['orderby']);}
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
	public function updateData2($data = array()){
		$this->db->where(array('meet_id' => $data['meet_id']));
		$this->db->update("tb_meet",$data);
		return $data['meet_id'];
	}

	// Insert data
	public function insertDetail($data = array()){
		$this->db->insert("tb_meetdetail",$data);
		return $this->db->insert_id();
	}
	public function updateDetail($data = array()){
		$this->db->where(array('dmeet_id' => $data['dmeet_id']));
		$this->db->update("tb_meetdetail",$data);
		return $data['dmeet_id'];
	}
	public function deleteMeet($data = array()){
		$this->db->delete('tb_meet', array('meet_id' => $data['meet_id']));
	}
	public function deleteDetailmeet($data = array()){
		$this->db->delete('tb_meetdetail', array('meet_id' => $data['meet_id']));
	}

	// ปิดเซต
	public function closeset($data = array()){
		$this->db->set('meet_status',0)->where('meet_id',$data['meet_id'])->update('tb_meet');
		$this->db->set('dmeet_status',0)->where('meet_id',$data['meet_id'])->update('tb_meetdetail');
	}

}