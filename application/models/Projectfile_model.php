<?php
class Projectfile_model extends CI_Model {

	// Get data
	public function listData($data = array()){
		$this->db->select($data['fide']);
		if(!empty($data['where'])){$this->db->where($data['where']);}
		if(!empty($data['orderby'])){$this->db->order_by($data['orderby']);}
		if(!empty($data['limit'])){$this->db->limit($data['limit'][0],$data['limit'][1]);}
		$query = $this->db->get('tb_projectfile');
		return $query->result_array();
    }

	public function listjoinData($data = array()){
        $this->db->select($data['fide']);
        $this->db->from('tb_projectfile');
		$this->db->join('tb_project', 'tb_project.project_id = tb_projectfile.project_id');
		if(!empty($data['where'])){$this->db->where($data['where']);}
		if(!empty($data['orderby'])){$this->db->order_by($data['orderby']);}
		if(!empty($data['limit'])){$this->db->limit($data['limit'][0],$data['limit'][1]);}
		$query = $this->db->get();
		return $query->result_array();
    }
    
    // Get data
	public function listformat($data = array()){
		$this->db->select($data['fide']);
		if(!empty($data['where'])){$this->db->where($data['where']);}
		if(!empty($data['orderby'])){$this->db->order_by($data['orderby']);}
		if(!empty($data['limit'])){$this->db->limit($data['limit'][0],$data['limit'][1]);}
		$query = $this->db->get('tb_projectfileformat');
		return $query->result_array();
	}

    // Insert data
	public function insertData($data = array()){
		$this->db->insert("tb_projectfile",$data);
		return $this->db->insert_id();
	}
	public function updateData($data = array()){
		$this->db->where(array('file_id' => $data['file_id']));
		$this->db->update("tb_projectfile",$data);
		return $data['file_id'];
	}
	public function deleteData($data = array()){
		$this->db->delete('tb_projectfile', array('file_id' => $data['file_id']));
		$this->db->delete('tb_trace', array('file_id' => $data['file_id']));
	}

	//
	// public function listtrace($data = array()){
	// 	$this->db->select($data['fide']);
	// 	if(!empty($data['where'])){$this->db->where($data['where']);}
	// 	if(!empty($data['orderby'])){$this->db->order_by($data['orderby']);}
	// 	if(!empty($data['limit'])){$this->db->limit($data['limit'][0],$data['limit'][1]);}
	// 	$query = $this->db->get('tb_trace');
	// 	return $query->result_array();
	// }
	public function listjointrace($data = array()){
        $this->db->select($data['fide']);
        $this->db->from('tb_projectfile');
		// $this->db->join('tb_project', 'tb_project.project_id = tb_projectfile.project_id');
		$this->db->join('tb_trace', 'tb_trace.file_id = tb_projectfile.file_id');
		if(!empty($data['where'])){$this->db->where($data['where']);}
		if(!empty($data['orderby'])){$this->db->order_by($data['orderby']);}
		if(!empty($data['limit'])){$this->db->limit($data['limit'][0],$data['limit'][1]);}
		$query = $this->db->get();
		return $query->result_array();
    }
	
	public function insertFiletrace($data = array()){
		$this->db->insert("tb_trace",$data);
		return $this->db->insert_id();
	}
}