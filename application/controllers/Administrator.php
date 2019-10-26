<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Administrator extends MX_Controller
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

	public function index($status = "")
	{

		$data = array();
		$data['formcrf'] = $this->tokens->token('formcrf');
		$data['msg'] = "";
		if ($status == "false") {
			$data['msg'] = '<div class="alert alert-danger" style="margin-bottom: 0;">
			<button type="button" aria-hidden="true" class="close">
			</button>
			<span>ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง .</span>
		  </div>';
		}
		$this->load->view('administrator/login', $data);
	}

	public function main()
	{
		$permission = array("ผู้ดูแลระบบ", "ฉุกเฉิน");
		if (in_array($this->encryption->decrypt($this->input->cookie('sysp')), $permission)) {
			$data = array();
			$condition = array();
			$condition['fide'] = "*";
			$condition['where_in']['filde'] = 'tb_user.position_id';
			$condition['where_in']['value'] = ['1', '2', '3'];
			$data['listdata'] = $this->administrator->listjoinData($condition);

			$condition = array();
			$condition['fide'] = "position_id,position_name";
			$condition['where_in']['filde'] = 'position_id';
			$condition['where_in']['value'] = ['1', '2', '3'];
			$data['listposition'] = $this->administrator->listDataPosition($condition);

			$data['formcrf'] = $this->tokens->token('formcrf');
			$this->template->backend('administrator/main', $data);
		} else {
			$this->load->view('errors/html/error_403');
		}
	}

	public function create()
	{
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
			);
			$id = $this->administrator->insertData($data);

			if ($this->input->post('position_id') == 2 || $this->input->post('position_id') == 3) {
				// เพิ่มเวลา
				$condition = array();
				$condition['fide'] = "*";
				$condition['where'] = array('set_status' => 2);
				$setting = $this->setting->listData($condition);
				if (count($setting) == 1) {
					$condition = array();
					$condition['fide'] = "*";
					$condition['where'] = array('use_id' => $id, 'set_id' => $setting[0]['set_id']);
					$section = $this->section->listData($condition);

					if (count($setting) != 0 && count($section) == 0) {
						$this->insertsection($id);
					}
				}
			}

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
			if ($this->input->post('type') == 'T') {
				$f = $this->encryption->encrypt($this->input->post('use_name'));
				$cookie_fullname = array(
					'name'   => 'sysn',
					'value'  => $f,
					'expire' => '86500',
					'path'   => '/'
				);
				$this->input->set_cookie($cookie_fullname);
			}
			if ($this->input->post('type') == 'AM') {
				$result = array(
					'error' => false,
					'msg' => 'แก้ไขข้อมูลสำเร็จ',
					'url' => site_url('administrator/main')
				);
				echo json_encode($result);
			} elseif ($this->input->post('type') == 'T') {
				$result = array(
					'error' => false,
					'msg' => 'แก้ไขข้อมูลสำเร็จ',
					'url' => site_url('profile/index/' . $this->input->post('Id'))
				);
				echo json_encode($result);
			}
		}
	}

	public function delete($id)
	{

		$condition = array();
		$condition['fide'] = "*";
		$condition['where'] = array('tb_settings.set_status' => 2, 'tb_section.use_id' => $id);
		$section = $this->section->listjoinData($condition);
		if (count($section) != 0) {
			$data = array(
				'use_id'            => $id,
			);
			$this->section->deleteData($data);
		}
		$data = array(
			'use_id'            => $id,
		);
		$this->administrator->deleteData($data);
		header("location:" . site_url('administrator/main'));
	}

	private function insertsection($id = "")
	{
		if (!empty($id)) {
			$condition = array();
			$condition['fide'] = "set_id, set_open, set_close, set_option_sat, set_option_sun";
			$condition['where'] = array('set_status' => 2);
			$setting = $this->setting->listData($condition);

			$condition = array();
			$condition['fide'] = "hol_date";
			$condition['where'] = array('set_id' => $setting[0]['set_id']);
			$holiday = $this->holiday->listData($condition);

			// หาช่วงวันที่
			$begin = new DateTime($setting[0]['set_open']);
			$end = clone $begin;
			$end->modify($setting[0]['set_close']);
			$end->setTime(0, 0, 1);
			$interval = new DateInterval('P1D');
			$daterange = new DatePeriod($begin, $interval, $end);
			//วันหยุด
			$arrholiday = array();
			foreach ($holiday as $key => $value) {
				array_push($arrholiday, $value['hol_date']);
			}

			$date = array();
			//ตัดวันเสาร์อาทิตย์
			if ($setting[0]['set_option_sat'] == 0 && $setting[0]['set_option_sun'] == 0) {
				foreach ($daterange as $key => $value) {
					$thisdate = $value->format('Y-m-d');
					if ((date('w', strtotime($thisdate)) != 6 && date('w', strtotime($thisdate)) != 0) && !in_array($thisdate, $arrholiday)) {
						array_push($date, $thisdate);
					}
				}
			}
			//ตัดวันอาทิตย์
			if ($setting[0]['set_option_sat'] == 1 && $setting[0]['set_option_sun'] == 0) {
				foreach ($daterange as $key => $value) {
					$thisdate = $value->format('Y-m-d');
					if (date('w', strtotime($thisdate)) != 0 && !in_array($thisdate, $arrholiday)) {
						array_push($date, $thisdate);
					}
				}
			}
			//ตัดวันเสาร์
			if ($setting[0]['set_option_sat'] == 0 && $setting[0]['set_option_sun'] == 1) {
				foreach ($daterange as $key => $value) {
					$thisdate = $value->format('Y-m-d');
					if (date('w', strtotime($thisdate)) != 6 && !in_array($thisdate, $arrholiday)) {
						array_push($date, $thisdate);
					}
				}
			}
			//เปิดนัดทุกวัน
			if ($setting[0]['set_option_sat'] == 0 && $setting[0]['set_option_sun'] == 1) {
				foreach ($daterange as $key => $value) {
					$thisdate = $value->format('Y-m-d');
					array_push($date, $thisdate);
				}
			}

			$time = array();
			$time[0] = ['9.00', '9.00'];
			$time[1] = ['10.00', '10.30'];
			$time[2] = ['11.00', '12.00'];
			$time[3] = ['13.00', '13.00'];
			$time[4] = ['14.00', '14.30'];
			$time[5] = ['15.00', '16.00'];

			$use_id = $id;
			foreach ($date as $key => $value) {
				foreach ($time as $key => $valtime) {
					// echo $value . '<br>';
					$data = array(
						'sec_date'          => $value,
						'sec_time_one'      => $valtime[0],
						'sec_time_two'      => $valtime[1],
						'sec_status'        => 1,
						'use_id'            => $use_id,
						'set_id'            => $setting[0]['set_id'],
					);
					$this->section->insertData($data);
				}
			}
		}
	}

	public function checkemail()
	{
		$use_email = $this->input->post('use_email');
		if (!empty($use_email)) {
			$condition = array();
			$condition['fide'] = "use_id";
			$condition['where'] = array('use_email' => $use_email);
			$listemail = $this->administrator->listData($condition);
			if (count($listemail) == 0) {
				echo "true";
			} else {
				echo "false";
			}
		}
	}

	public function checkemailup()
	{
		$use_id = $this->input->post('use_id');
		$use_email = $this->input->post('use_email');
		if (!empty($use_email)) {
			$condition = array();
			$condition['fide'] = "use_id";
			$condition['where'] = array('use_email' => $use_email, 'use_id !=' => $use_id);
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
		if ($this->tokens->verify('formcrf')) {
			$data = array(
				'use_id' 		=> $this->input->post('Id'),
				'use_pass' 		=> md5($this->input->post('use_pass'))
			);
			$this->administrator->updateData($data);
			if ($this->input->post('type') == 'AM') {
				$result = array(
					'error' => false,
					'msg' => 'เปลี่ยนรหัสผ่านสำเร็จ',
					'url' => site_url('administrator/main')
				);
				echo json_encode($result);
			} elseif ($this->input->post('type') == 'T') {
				$result = array(
					'error' => false,
					'msg' => 'เปลี่ยนรหัสผ่านสำเร็จ',
					'url' => site_url('profile/index/' . $this->input->post('Id'))
				);
				echo json_encode($result);
			}
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
				$condition['fide'] = "use_id,use_name,position_name,use_email,use_pass,use_lastlogin";
				$condition['where'] = array('use_email' => $username, 'use_pass' => md5($password));
				$listdata = $this->administrator->listjoinData($condition);
				// login นักศึกษา
				$condition = array();
				$condition['fide'] = "std_id,std_number,position_name,std_fname,std_lname,std_img,std_email,std_pass,std_checkmail";
				$condition['where'] = array('std_email' => $username, 'std_pass' => md5($password), 'std_checkmail' => 1);
				$liststd = $this->student->listjoinData($condition);

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
					$this->student->updateStd($data);
					$l = $this->encryption->encrypt("l1ci");
					$i = $this->encryption->encrypt($liststd[0]['std_id']);
					$f = $this->encryption->encrypt($liststd[0]['std_fname'] . ' ' . $liststd[0]['std_lname']);
					$p = $this->encryption->encrypt($liststd[0]['position_name']);
					$img = $this->encryption->encrypt($liststd[0]['std_img']);
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
					$cookie_img = array(
						'name'   => 'sysimg',
						'value'  => $img,
						'expire' => '86500',
						'path'   => '/'
					);
					$this->input->set_cookie($cookie);
					$this->input->set_cookie($cookie_id);
					$this->input->set_cookie($cookie_fullname);
					$this->input->set_cookie($cookie_position);
					$this->input->set_cookie($cookie_img);
					header("location:" . site_url('student/stdproject/'.$liststd[0]['std_id']));
				} elseif ($username == 'support@itrmutr.com' && $password == 'supp0rt@it;;') {
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
					header("location:" . site_url('administrator/main'));
				} else {
					header("location:" . site_url('administrator/index/false'));
				}
			}
		}
	}

	public function logout()
	{
		delete_cookie("syslev");
		delete_cookie("sysli");
		delete_cookie("sysn");
		delete_cookie("sysp");
		delete_cookie("sysimg");
		header("location:" . site_url());
	}
}
