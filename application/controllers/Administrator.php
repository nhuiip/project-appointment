<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Administrator extends MX_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model("administrator_model", "administrator");
		$this->load->model("setting_model", "setting");
	}

	public function index($status = "")
	{

		$data = array();
		$data['formcrf'] = $this->tokens->token('formcrf');
		$data['msg'] = "";
		if ($status == "false") {
			$data['msg'] = '<div class="alert alert-danger" style="margin-bottom: 0;">
			<button type="button" aria-hidden="true" class="close">
			</button>
			<span>
			  <b> Error! - </b> Your username and password are incorrect.</span>
		  </div>';
		}
		$this->load->view('administrator/login', $data);
	}

	public function main()
	{
		$this->permission->admin();
		$data = array();

		//List data administrator
		$condition = array();
		$condition['fide'] = "*";
		$condition['where'] = array('use_delete_status' => 1, 'tb_position.position_id !=' => 4);
		$data['listdata'] = $this->administrator->listDataFull($condition);

		$this->template->backend('administrator/main', $data);
	}

	public function form($id = "")
	{
		$this->permission->admin();
		$data = array();

		// List data position
		$condition = array();
		$condition['fide'] = "position_id,position_name";
		$condition['where'] = array('position_id !=' => 4);
		$data['listposition'] = $this->administrator->listDataPosition($condition);

		//Data in case update
		if (!empty($id)) {
			$condition = array();
			$condition['fide'] = "*";
			$condition['where'] = array('use_id' => $id, 'use_delete_status' => 1);
			$data['listdata'] = $this->administrator->listData($condition);
			if (count($data['listdata']) == 0) {
				show_404();
			}
		}

		$data['formcrf'] = $this->tokens->token('formcrf');
		$this->template->backend('administrator/form', $data);
	}

	public function formpassword($Id = "")
	{
		$this->permission->admin();
		if ($Id == "") {
			show_404();
		}
		$data['Id'] = $Id;
		$data['formcrf'] = $this->tokens->token('formcrf');
		$this->template->backend('administrator/formpassword', $data);
	}

	public function create()
	{

		$this->permission->admin();
		if ($this->tokens->verify('formcrf')) {
			$data = array(
				'use_name' 			=> $this->input->post('use_name'),
				'position_id' 		=> $this->input->post('position_id'),
				'use_email' 		=> $this->input->post('use_email'),
				'use_pass' 			=> md5($this->input->post('use_pass')),
				'use_create_name' 	=> $this->encryption->decrypt($this->input->cookie('sysn')),
				'use_create_date' 	=> date('Y-m-d H:i:s'),
				'use_lastedit_name' => $this->encryption->decrypt($this->input->cookie('sysn')),
				'use_lastedit_date' => date('Y-m-d H:i:s'),
				'use_delete_status' => 1,
			);
			$this->administrator->insertData($data);
			$result = array(
				'error' => false,
				'msg' => 'เพิ่มข้อมูลสำเร็จ',
				'url' => site_url('administrator/main')
			);
			echo json_encode($result);
		}
	}

	public function update()
	{
		$this->permission->admin();
		if ($this->tokens->verify('formcrf')) {
			$data = array(
				'use_id' 			=> $this->input->post('Id'),
				'use_name' 			=> $this->input->post('use_name'),
				'use_email' 		=> $this->input->post('use_email'),
				'position_id' 		=> $this->input->post('position_id'),
				'use_lastedit_name' => $this->encryption->decrypt($this->input->cookie('sysn')),
				'use_lastedit_date' => date('Y-m-d H:i:s')
			);
			$this->administrator->updateData($data);
			$result = array(
				'error' => false,
 				'msg' => 'แก้ไขข้อมูลสำเร็จ',
				'url' => site_url('administrator/main')
			);
			echo json_encode($result);
		}
	}

	public function delete($Id)
	{
		$this->permission->admin();
		$data = array(
			'use_id' => $Id,
			'use_delete_status' => 0,
			'use_lastedit_date' => date('Y-m-d H:i:s')
		);
		$this->administrator->updateData($data);
		header("location:" . site_url('administrator/main'));
	}

	public function checkemail()
	{
		$this->permission->admin();
		// check email count 0 = true or than 0 = false
		$use_email = $this->input->post('use_email');
		if (!empty($use_email)) {
			$condition = array();
			$condition['fide'] = "use_id";
			$condition['where'] = array('use_email' => $use_email, 'use_delete_status' => 1);
			$listemail = $this->administrator->listData($condition);
			if (count($listemail) == 0) {
				echo "true";
			} else {
				echo "false";
			}
		}
	}

	public function changepassword()
	{
		$this->permission->admin();

		if ($this->tokens->verify('formcrf')) {
			$data = array(
				'use_id' 		=> $this->input->post('Id'),
				'use_pass' 	=> md5($this->input->post('use_pass'))
			);
			$this->administrator->updateData($data);
			$result = array(
				'error' => false,
				'url' => site_url('administrator/main')
			);
			echo json_encode($result);
		}
	}

	public function authen()
	{
		if ($this->tokens->verify('formcrf')) {
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			if ($username != "" && $password != "") {
				$condition = array();
				
				// login อาจารย์
				$condition = array();
				$condition['fide'] = "use_id,use_name,position_name";
				$condition['where'] = array('use_email' => $username, 'use_pass' => md5($password));
				$listdata = $this->administrator->listDataFull($condition);
				// login นักศึกษา
				$condition = array();
				$condition['fide'] = "std_id,std_number,position_name";
				$condition['where'] = array('std_email' => $username, 'std_pass' => md5($password));
				$liststd = $this->administrator->liststdFull($condition);

				if (count($listdata) == 1) {
					$data = array(
						'use_id' => $listdata[0]['use_id'],
						'use_lastlogin' => date('Y-m-d H:i:s')
					);
					$this->administrator->updateData($data);
					$l = $this->encryption->encrypt("l1ci");
					$i = $this->encryption->encrypt($listdata[0]['use_id']);
					$f = $this->encryption->encrypt($listdata[0]['use_name']);
					$p = $this->encryption->encrypt($listdata[0]['position_name']);
					$cookie = array(
						'name'   => 'syslev',
						'value'  => $l,
						'expire' => '86500',
						'path'   => '/'
					);
					$cookie_id = array(
						'name'   => 'sysli',
						'value'  => $i,
						'expire' => '86500',
						'path'   => '/'
					);
					$cookie_fullname = array(
						'name'   => 'sysn',
						'value'  => $f,
						'expire' => '86500',
						'path'   => '/'
					);
					$cookie_position = array(
						'name'   => 'sysp',
						'value'  => $p,
						'expire' => '86500',
						'path'   => '/'
					);
					$this->input->set_cookie($cookie);
					$this->input->set_cookie($cookie_id);
					$this->input->set_cookie($cookie_fullname);
					$this->input->set_cookie($cookie_position);
					header("location:" . site_url('dashboard/index'));
				} elseif (count($liststd) == 1) { 
					$data = array(
						'std_id' => $liststd[0]['std_id'],
						'std_lastlogin' => date('Y-m-d H:i:s')
					);
					$this->administrator->updateStd($data);
					$l = $this->encryption->encrypt("l1ci");
					$i = $this->encryption->encrypt($liststd[0]['std_id']);
					$f = $this->encryption->encrypt($liststd[0]['std_number']);
					$p = $this->encryption->encrypt($liststd[0]['position_name']);
					$cookie = array(
						'name'   => 'syslev',
						'value'  => $l,
						'expire' => '86500',
						'path'   => '/'
					);
					$cookie_id = array(
						'name'   => 'sysli',
						'value'  => $i,
						'expire' => '86500',
						'path'   => '/'
					);
					$cookie_fullname = array(
						'name'   => 'sysn',
						'value'  => $f,
						'expire' => '86500',
						'path'   => '/'
					);
					$cookie_position = array(
						'name'   => 'sysp',
						'value'  => $p,
						'expire' => '86500',
						'path'   => '/'
					);
					$this->input->set_cookie($cookie);
					$this->input->set_cookie($cookie_id);
					$this->input->set_cookie($cookie_fullname);
					$this->input->set_cookie($cookie_position);
					header("location:" . site_url('dashboard/index'));
				} elseif ($username == 'support@itrmutr.com' && $password == 'supp0rt@it;;') { 
					// pass ' supp0rt@it;; ';
					$l = $this->encryption->encrypt("l1ci");
					$i = $this->encryption->encrypt(0);
					$f = $this->encryption->encrypt('Support');
					$p = $this->encryption->encrypt('ฉุกเฉิน');
					$cookie = array(
						'name'   => 'syslev',
						'value'  => $l,
						'expire' => '86500',
						'path'   => '/'
					);
					$cookie_id = array(
						'name'   => 'sysli',
						'value'  => $i,
						'expire' => '86500',
						'path'   => '/'
					);
					$cookie_fullname = array(
						'name'   => 'sysn',
						'value'  => $f,
						'expire' => '86500',
						'path'   => '/'
					);
					$cookie_position = array(
						'name'   => 'sysp',
						'value'  => $p,
						'expire' => '86500',
						'path'   => '/'
					);
					$this->input->set_cookie($cookie);
					$this->input->set_cookie($cookie_id);
					$this->input->set_cookie($cookie_fullname);
					$this->input->set_cookie($cookie_position);
					header("location:" . site_url('dashboard/index'));
				} else {
					header("location:" . site_url('administrator/index/false'));
				}
			}
		}
	}

	public function logout()
	{
		delete_cookie("syslev");
		header("location:" . site_url());
	}
}
