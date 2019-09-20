<?php
class Profile_model extends CI_Model {

    // Insert data
	public function insertData($data = array()){
		$this->db->insert("tb_section",$data);
		return $this->db->insert_id();
	}
	public function updateData($data = array()){
		$this->db->where(array('sec_id' => $data['sec_id']));
		$this->db->update("tb_section",$data);
		return $data['sec_id'];
	}

	public function updateStd($data = array()){
		$this->db->where(array('std_id' => $data['std_id']));
		$this->db->update("tb_student",$data);
		return $data['std_id'];
	}

}