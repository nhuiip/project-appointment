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
		$this->load->model("holiday_model", "holiday");
	}

	public function index()
	{
		$permission = array("ผู้ดูแลระบบ", "หัวหน้าสาขา", "อาจารย์ผู้สอน", "ฉุกเฉิน");
		if (in_array($this->encryption->decrypt($this->input->cookie('sysp')), $permission)) {
			$data = array();
			$condition = array();
			$condition['fide'] = "*";
			$condition['where'] = array('tb_position.position_id' => 5);
			$data['listdata'] = $this->administrator->listjoinData($condition);

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
		header("location:" . site_url('extra/index'));
	}




}
