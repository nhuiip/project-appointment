<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Profile extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("student_model", "student");
        $this->load->model("project_model", "project");
        $this->load->model("subject_model", "subject");
        $this->load->model("administrator_model", "administrator");
    }

    public function index($id = "")
    {

        $poslogin   = $this->encryption->decrypt($this->input->cookie('sysp'));
        $idlogin    = $this->encryption->decrypt($this->input->cookie('sysli'));

        if (!empty($this->encryption->decrypt($this->input->cookie('syslev')))) {
            if ($id == "") {
                show_404();
            } elseif ($poslogin == 'นักศึกษา' && $idlogin == $id) {
                $condition = array();
                $condition['fide'] = "std_id";
                $condition['where'] = array('std_id' => $id);
                $checkstudent = $this->student->listData($condition);
                if (count($checkstudent) == 0) {
                    show_404();
                } else {
                    $data = array();
                    $condition = array();
                    $condition['fide'] = "*";
                    $condition['where'] = array('std_id' => $id);
                    $data['liststudent'] = $this->student->listjoinData($condition);

                    $data['searchProject'] = $this->project->searchstdProject($this->encryption->decrypt($this->input->cookie('sysli')));

                    $data['formcrf'] = $this->tokens->token('formcrf');
                    $data['formcrfmail'] = $this->tokens->token('formcrfmail');
                    $data['formcrfpassword'] = $this->tokens->token('formcrfpassword');

                    $this->template->backend('student/profile', $data);
                }
            } elseif (($poslogin != 'นักศึกษา' && $idlogin == $id) && ($poslogin != 'ผู้ดูแลระบบ' && $poslogin != 'ฉุกเฉิน')) {

                $data = array();
                $condition = array();
                $condition['fide'] = "*";
                $condition['where'] = array('use_id' => $id);
                $data['listdata'] = $this->administrator->listjoinData($condition);

                $condition = array();
                $condition['fide'] = "*";
                $condition['where'] = array('tb_subject.use_id' => $id, 'tb_subject.sub_status' => 1, 'tb_settings.set_status' => 2);
                $data['listsubject'] = $this->subject->listjoinData($condition);

                $data['formcrf'] = $this->tokens->token('formcrf');

                $this->template->backend('administrator/profile', $data);
            } else {
                $this->load->view('errors/html/error_403');
            }
        } else {
            show_404();
        }
    }

    public function update($Id = "")
    {
        if ($Id == "") {
            show_404();
        } else if ($this->encryption->decrypt($this->input->cookie('sysp')) == 'นักศึกษา') {
            $condition = array();
            $condition['fide'] = "std_id";
            $condition['where'] = array('std_id' => $Id);
            $checkstudent = $this->student->listData($condition);
            if (count($checkstudent) == 0) {
                $this->load->view('errors/html/error_403');
            } else {

                if ($this->tokens->verify('formcrf')) {
                    $data = array(
                        'std_id'                => $this->input->post('Id'),
                        'std_img'               => $this->input->post('std_number') . '.png',
                        'std_fname'             => $this->input->post('text_name'),
                        'std_lname'             => $this->input->post('text_lastname'),
                        'std_tel'               => $this->input->post('text_tel'),
                        'std_lastedit_name'     => $this->encryption->decrypt($this->input->cookie('sysn')),
                        'std_lastedit_date'     => date('Y-m-d H:i:s'),
                    );

                    $this->student->updateStd($data);

                    if ($this->input->post('std_img') != '') {
                        define('UPLOAD_DIR', './uploads/student/');
                        $img = $this->input->post('std_img');
                        $img = str_replace('data:image/jpeg;base64,', '', $img);
                        $img = str_replace('data:image/jpg;base64,', '', $img);
                        $img = str_replace('data:image/png;base64,', '', $img);
                        $img = str_replace('data:image/gif;base64,', '', $img);
                        $img = str_replace(' ', '+', $img);
                        $data = base64_decode($img);
                        $file = UPLOAD_DIR  . $this->input->post('std_number') . '.png';
                        file_put_contents($file, $data);
                    }

                    $condition = array();
                    $condition['fide'] = "std_id,std_fname,std_lname";
                    $condition['where'] = array('std_id' => $this->input->post('Id'));
                    $liststd = $this->student->listData($condition);

                    $f = $this->encryption->encrypt($liststd[0]['std_fname'] . ' ' . $liststd[0]['std_lname']);
					$cookie_fullname = array(
						'name'   => 'sysn',
						'value'  => $f,
						'expire' => '86500',
						'path'   => '/'
					);
                    $this->input->set_cookie($cookie_fullname);
                    
                    if (!empty($Id)) {
                        $result = array(
                            'error' => false,
                            'msg' => 'แก้ไขข้อมูลสำเร็จ',
                            'url' => site_url('profile/index/' . $Id)
                        );
                        echo json_encode($result);
                    } else {
                        $result = array(
                            'error' => true,
                            'title' => "ล้มเหลว",
                            'msg' => 'อัพเดตข้อมูลไม่สำเร็จ',
                        );
                        echo json_encode($result);
                    }
                    die;
                } else {
                    $result = array(
                        'error' => true,
                        'title' => "ล้มเหลว",
                        'msg' => "อัพเดตข้อมูลไม่สำเร็จ"
                    );
                    echo json_encode($result);
                }
            }
        }
    }

    public function changemail()
    {
        $Id  =  $this->input->post('Idmail');
        if ($Id == "") {
            $this->load->view('errors/html/error_403');
        } else if ($this->encryption->decrypt($this->input->cookie('sysp')) == 'นักศึกษา') {


            $condition = array();
            $condition['fide'] = "std_id";
            $condition['where'] = array('std_id' => $Id);
            $checkstudent = $this->student->listData($condition);
            if (count($checkstudent) == 0) {
                $this->load->view('errors/html/error_403');
            } else {

                if ($this->tokens->verify('formcrfmail')) {
                    $data = array(
                        'std_id'                => $this->input->post('Idmail'),
                        'std_email'             => $this->input->post('std_email'),
                        'std_lastedit_name'     => $this->encryption->decrypt($this->input->cookie('sysn')),
                        'std_lastedit_date'     => date('Y-m-d H:i:s'),
                    );

                    $this->student->updateStd($data);

                    if (!empty($Id)) {
                        $result = array(
                            'error' => false,
                            'msg' => 'เปลี่ยนที่อยู่อีเมล์แล้ว กรุณาเข้าสู่ระบบใหม่อีกครั้ง',
                            'url' => site_url('administrator/logout')
                        );
                        echo json_encode($result);
                    } else {
                        $result = array(
                            'error' => true,
                            'title' => "ล้มเหลว",
                            'msg' => 'เปลี่ยนที่อยู่อีเมล์ไม่สำเร็จ',
                        );
                        echo json_encode($result);
                    }
                    die;
                } else {
                    $result = array(
                        'error' => true,
                        'title' => "ล้มเหลว",
                        'msg' => "เปลี่ยนที่อยู่อีเมล์ไม่สำเร็จ"
                    );
                    echo json_encode($result);
                }
            }
        }
    }

    public function checkemail()
	{
		// check email count 0 = true or than 0 = false
		$std_email = $this->input->post('std_email');
		if (!empty($std_email)) {
			$condition = array();
			$condition['fide'] = "std_email";
			$condition['where'] = array('std_email' => $std_email);
			$listemail = $this->student->listData($condition);
			if (count($listemail) == 0) {
                
                $condition = array();
                $condition['fide'] = "use_email";
                $condition['where'] = array('use_email' => $std_email);
                $listemails = $this->administrator->listData($condition);
            
                if (count($listemails) == 0) {
                    echo "true";
                } else {
                    echo "false";
                }

			} else {
				echo "false";
			}
		}
    }
    
    public function changepassword()
	{

		if ($this->tokens->verify('formcrfpassword')) {
			$data = array(
				'std_id' 		=> $this->input->post('Id2'),
				'std_pass' 		=> md5($this->input->post('std_password'))
            );
            
            $Id = $this->student->updateStd($data);
            
            if (!empty($Id)) {
                $result = array(
                    'error' => false,
                    'msg' => 'เปลี่ยนรหัสผ่านเรียบร้อยแล้ว',
                    'url' => site_url('profile/index/' .$this->input->post('Id2'))
                );
                echo json_encode($result);
            } else {
                $result = array(
                    'error' => true,
                    'title' => "ล้มเหลว",
                    'msg' => 'อัพเดตข้อมูลไม่สำเร็จ',
                );
                echo json_encode($result);
            }
            die;
        } else {
            $result = array(
                'error' => true,
                'title' => "ล้มเหลว",
                'msg' => "อัพเดตข้อมูลไม่สำเร็จ"
            );
            echo json_encode($result);
        }

	}
}
