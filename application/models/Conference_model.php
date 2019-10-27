<?php
class Conference_model extends CI_Model {

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
        $this->db->from('tb_conference');
		$this->db->join('tb_project', 'tb_project.project_id = tb_conference.project_id');
		$this->db->join('tb_conferencetype', 'tb_conferencetype.conftype_id = tb_conference.conftype_id');
		if(!empty($data['where'])){$this->db->where($data['where']);}
		if(!empty($data['orderby'])){$this->db->order_by($data['orderby']);}
		if(!empty($data['limit'])){$this->db->limit($data['limit'][0],$data['limit'][1]);}
		$query = $this->db->get();
		return $query->result_array();
	}

    // Insert data
	public function insertData($data = array()){
		$this->db->insert("tb_conference",$data);
		return $this->db->insert_id();
	}
	public function updateData($data = array()){
		$this->db->where(array('conf_id' => $data['conf_id']));
		$this->db->update("tb_conference",$data);
		return $data['conf_id'];
	}
	public function deleteData($data = array()){
		$this->db->delete('tb_conference', array('conf_id' => $data['conf_id']));
    }
    
    // Insert Preson
	public function insertPerson($data = array()){
		$this->db->insert("tb_conferenceperson",$data);
		return $this->db->insert_id();
	}
	public function updatePerson($data = array()){
		$this->db->where(array('confpos_id' => $data['confpos_id']));
		$this->db->update("tb_conferenceperson",$data);
		return $data['confpos_id'];
	}
	public function deletePerson($data = array()){
		$this->db->delete('tb_conferenceperson', array('confpos_id' => $data['confpos_id']));
	}
}