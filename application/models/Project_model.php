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
		$this->db->join('tb_projectperson', 'tb_projectperson.project_id = tb_project.project_id');
		$this->db->join('tb_student', 'tb_student.std_id = tb_projectperson.std_id');
		if(!empty($data['where'])){$this->db->where($data['where']);}
		if(!empty($data['orderby'])){$this->db->order_by($data['orderby']);}
		if(!empty($data['limit'])){$this->db->limit($data['limit'][0],$data['limit'][1]);}
		$query = $this->db->get();
		return $query->result_array();
	}

	public function listjoinData2($data = array()){
        $this->db->select($data['fide']);
        $this->db->from('tb_project');
		$this->db->join('tb_user', 'tb_user.use_id = tb_project.use_id');
		if(!empty($data['where'])){$this->db->where($data['where']);}
		if(!empty($data['orderby'])){$this->db->order_by($data['orderby']);}
		if(!empty($data['limit'])){$this->db->limit($data['limit'][0],$data['limit'][1]);}
		$query = $this->db->get();
		return $query->result_array();
	}

	public function listperson($data = array()){
        $this->db->select($data['fide']);
        $this->db->from('tb_projectperson');
		$this->db->join('tb_student', 'tb_student.std_id = tb_projectperson.std_id');
		$this->db->join('tb_project', 'tb_project.project_id = tb_projectperson.project_id');
		if(!empty($data['where'])){$this->db->where($data['where']);}
		if(!empty($data['orderby'])){$this->db->order_by($data['orderby']);}
		if(!empty($data['limit'])){$this->db->limit($data['limit'][0],$data['limit'][1]);}
		$query = $this->db->get();
		return $query->result_array();
	}


	public function count_all_news()
    {
        $this->db->select('*');
        $query = $this->db->get('tb_project');
        return count($query->result_array());
	}


	// Select project name
	public function getData($rowno,$rowperpage,$search="") {
 
		$this->db->select('*');
		$this->db->from('tb_project');
		$this->db->join('tb_user', 'tb_user.use_id = tb_project.use_id');

		if($search != ''){
			$this->db->like('tb_project.project_name', $search);
		}

		$this->db->limit($rowperpage, $rowno); 
		$query = $this->db->get();
		
		return $query->result_array();
	}

	public function getrecordCount($search="") {

		$this->db->select('count(*) as allcount');
		$this->db->from('tb_project');
		$this->db->join('tb_user', 'tb_user.use_id = tb_project.use_id');
	
		if($search != ''){
			$this->db->like('tb_project.project_name', $search);
		}

		$query = $this->db->get();
		$result = $query->result_array();
	
		return $result[0]['allcount'];
	}

	// Select project status
	public function getDataStatus($rowno,$rowperpage,$search="") {
 
		$this->db->select('*');
		$this->db->from('tb_project');
		$this->db->join('tb_user', 'tb_user.use_id = tb_project.use_id');

		if($search != ''){
			$this->db->like('tb_project.project_status', $search);
		}

		$this->db->limit($rowperpage, $rowno); 
		$query = $this->db->get();
		
		return $query->result_array();
	}

	public function getrecordCountStatus($search="") {

		$this->db->select('count(*) as allcount');
		$this->db->from('tb_project');
		$this->db->join('tb_user', 'tb_user.use_id = tb_project.use_id');
	
		if($search != ''){
			$this->db->like('tb_project.project_status', $search);
		}

		$query = $this->db->get();
		$result = $query->result_array();
	
		return $result[0]['allcount'];
		
	}

	// Select project teacher
	public function getDataTeacher($rowno,$rowperpage,$search="") {
 
		$this->db->select('*');
		$this->db->from('tb_project');
		$this->db->join('tb_user', 'tb_user.use_id = tb_project.use_id');

		if($search != ''){
			$this->db->like('tb_project.use_id', $search);
		}

		$this->db->limit($rowperpage, $rowno); 
		$query = $this->db->get();
		
		return $query->result_array();
	}

	public function getrecordCountTeacher($search="") {

		$this->db->select('count(*) as allcount');
		$this->db->from('tb_project');
		$this->db->join('tb_user', 'tb_user.use_id = tb_project.use_id');
	
		if($search != ''){
			$this->db->like('tb_project.use_id', $search);
		}

		$query = $this->db->get();
		$result = $query->result_array();
	
		return $result[0]['allcount'];
		
	}

	// public function searchstdProject($Id){
	// 	$query = $this->db->query("SELECT * FROM tb_project WHERE FIND_IN_SET(".$Id.",std_id)" );
	// 	return $query->result_array();
	// }


	public function searchstdProjectNumber($searchstudent){
		$this->db->select('*');
		$this->db->like('std_number',$searchstudent);
		$query = $this->db->get('tb_student');
		return $query->result_array();
	}

	public function searchstdId($Id){
		$this->db->select('*');
		$this->db->like('std_id',$Id);
		$query = $this->db->get('tb_student');
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
	public function insertPerson($data = array()){
		$this->db->insert("tb_projectperson",$data);
		return $this->db->insert_id();
	}

	public function updateData($data = array()){
		$this->db->where(array('project_id' => $data['project_id']));
		$this->db->update("tb_project",$data);
		return $data['project_id'];
	}
	public function updateDatas($datas = array()){
		$this->db->where(array('project_id' => $datas['project_id']));
		$this->db->update("tb_project",$datas);
		return $datas['project_id'];
	}

	public function updateData2($other = array()){
		$this->db->where(array('project_id' => $other['project_id']));
		$this->db->update("tb_project",$other);
		return $other['project_id'];
	}
	public function deleteData($data = array()){
		$this->db->delete('tb_project', array('project_id' => $data['project_id']));
	}
}