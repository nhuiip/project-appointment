<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Extra extends MX_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model("administrator_model", "administrator");
		$this->load->model("setting_model", "setting");
		$this->load->model("section_model", "section");
		$this->load->model("student_model", "student");
		$this->load->model("subject_model", "subject");
		$this->load->model("holiday_model", "holiday");
	}

	public function index()
	{
		$permission = array("ผู้ดูแลระบบ", "หัวหน้าสาขา", "อาจารย์ผู้สอน");
		if (in_array($this->encryption->decrypt($this->input->cookie('sysp')), $permission)) {
			$data = array();
			$condition = array();
			$condition['fide'] = "*";
			$condition['where'] = array('tb_position.position_id' => 5);
			$condition['orderby'] = "use_name ASC ";
			$data['listdata'] = $this->administrator->listjoinData($condition);
			// checkinsert
			$condition = array();
			$condition['fide'] = "set_status, set_id";
			$condition['where'] = array('set_status' => 2);
			$checkinsert = $this->setting->listData($condition);
			if (count($checkinsert) == 1) {
				$data['checkinsert'] = 'yes';
				$data['set_id'] = $checkinsert[0]['set_id'];

				$condition['fide'] = "*";
				$condition['where'] = array('set_id' => $checkinsert[0]['set_id']);
				$condition['groupby'] = "sec_date";
				$data['listsec'] = $this->section->listData($condition);
			} else {
				$data['checkinsert'] = 'no';
			}

			$condition = array();
			$condition['fide'] = "*";
			$condition['where'] = array('sub_status' => 1);
			$data['listsubject'] = $this->subject->listData($condition);

			$data['formcrf'] = $this->tokens->token('formcrf');
			$this->template->backend('administrator/extra', $data);
		} else {
			$this->load->view('errors/html/error_403');
		}
	}

	public function create()
	{
		if ($this->tokens->verify('formcrf')) {
			$data = array(
				'use_name' 			=> $this->input->post('use_name'),
				'position_id' 		=> 5,
				'use_email' 		=> '',
				'use_pass' 			=> '',
				'use_create_name' 	=> $this->encryption->decrypt($this->input->cookie('sysn')),
				'use_create_date' 	=> date('Y-m-d H:i:s'),
				'use_lastedit_name' => $this->encryption->decrypt($this->input->cookie('sysn')),
				'use_lastedit_date' => date('Y-m-d H:i:s'),
			);
			$id = $this->administrator->insertData($data);

			// insert sectione
			$sec = array();
			$sec['sec_date'] = $this->input->post('sec_date');
			if ($this->input->post('text_type') == 1) {
				$sec['sec_time_one'] = $this->input->post('text_time');
				$sec['sec_time_two'] = "";
			} elseif ($this->input->post('text_type') == 2) {
				$sec['sec_time_one'] = "";
				$sec['sec_time_two'] = $this->input->post('text_time');
			}
			$sec['sec_status'] = 1;
			$sec['use_id'] = $id;
			$sec['set_id'] = $this->input->post('set_id');

			$this->section->insertEx($sec);

			$result = array(
				'error' => false,
				'msg' => 'เพิ่มข้อมูลสำเร็จ',
				'url' => site_url('extra/index')
			);
			echo json_encode($result);
		}
	}

	
	public function update()
	{
		if ($this->tokens->verify('formcrf')) {
			$data = array(
				'use_id' 			=> $this->input->post('Id'),
				'use_name' 			=> $this->input->post('use_name'),
				'use_lastedit_name' => $this->encryption->decrypt($this->input->cookie('sysn')),
				'use_lastedit_date' => date('Y-m-d H:i:s')
			);
			$this->administrator->updateData($data);
			$result = array(
				'error' => false,
				'msg' => 'แก้ไขข้อมูลสำเร็จ',
				'url' => site_url('extra/index')
			);
			echo json_encode($result);
		}
	}

	public function delete($id)
	{
		$data = array(
			'use_id'            => $id,
		);
		$this->administrator->deleteData($data);
		$condition['fide'] = "*";
		$condition['where'] = array('use_id' => $id);
		$listData = $this->section->listData($condition);
		if(count($listData) != 0){
			$data = array(
				'use_id'            => $id,
			);
			$this->section->deleteData($data);
		}

		header("location:" . site_url('extra/index'));
	}
}
