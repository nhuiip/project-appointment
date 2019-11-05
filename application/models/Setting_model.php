<?php
class Setting_model extends CI_Model
{

	// Get data
	public function listData($data = array())
	{
		$this->db->select($data['fide']);
		if (!empty($data['where'])) {
			$this->db->where($data['where']);
		}
		if (!empty($data['orderby'])) {
			$this->db->order_by($data['orderby']);
		}
		if (!empty($data['limit'])) {
			$this->db->limit($data['limit'][0], $data['limit'][1]);
		}
		$query = $this->db->get('tb_settings');
		return $query->result_array();
	}
	// Insert data
	public function insertData($data = array())
	{
		$this->db->insert("tb_settings", $data);
		return $this->db->insert_id();
	}
	public function updateData($data = array())
	{
		$this->db->where(array('set_id' => $data['set_id']));
		$this->db->update("tb_settings", $data);
		return $data['set_id'];
	}

	public function CloseData($data = array())
	{
		$this->db->where(array('set_id' => $data['set_id']));
		$this->db->update("tb_settings", $data);
		if ($data['set_status'] == 0) {
			$this->db->delete('tb_section', array('set_id' => $data['set_id']));
		}
		return $data['set_id'];
	}
}
