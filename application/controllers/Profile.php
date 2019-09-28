<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Profile extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("student_model", "student");
        $this->load->model("subject_model", "subject");
        $this->load->model("administrator_model", "administrator");
    }

    public function index($id = "")
    {
        $poslogin   = $this->input->cookie('sysp');
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
                    $data['liststudent'] = $this->student->listjoinData($condition);

                    $condition = array();
                    $condition['fide'] = "*";
                    $data['listsubject'] = $this->subject->listData($condition);

                    // $data['position'] = $poslogin;
                    $data['formcrf'] = $this->tokens->token('formcrf');
                    $this->template->backend('student/profile', $data);
                }
            } elseif (($poslogin != 'นักศึกษา' && $idlogin == $id) && ($poslogin != 'ผู้ดูแลระบบ' && $poslogin != 'ฉุกเฉิน')) {

                $data = array();
                $condition = array();
                $condition['fide'] = "*";
                $condition['where'] = array('use_id' => $id);
                $data['listdata'] = $this->administrator->listjoinData($condition);

                $condition = array();
                $condition['fide'] = "'tb_subject.use_id' => $id, 'tb_subject.sub_status' => 1, 'tb_settings.set_status' => 2";
                $condition['orderby'] = "set_id DESC  ";
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
                // $this->load->view('errors/html/error_403');
            } else {

                if ($this->tokens->verify('formcrf')) {
                    $data = array(
                        'std_id'                => $this->input->post('Id'),
                        'std_img'               => $this->upfileimages('std_img', 'std_number'),
                        'std_fname'             => $this->input->post('text_name'),
                        'std_lname'             => $this->input->post('text_lastname'),
                        'std_tel'               => $this->input->post('text_tel'),
                        'std_lastedit_name'     => $this->encryption->decrypt($this->input->cookie('sysn')),
                        'std_lastedit_date'     => date('Y-m-d H:i:s'),
                    );

                    $this->student->updateStd($data);

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

    public function changemail($Id = "")
    {
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

                if ($this->tokens->verify('formcrf')) {
                    $data = array(
                        'std_id'                => $this->input->post('Id'),
                        'std_emailchang'             => $this->input->post('text_email'),
                        'std_lastedit_name'     => $this->encryption->decrypt($this->input->cookie('sysn')),
                        'std_lastedit_date'     => date('Y-m-d H:i:s'),
                    );

                    $this->student->updateStd($data);

                    if (!empty($Id)) {
                        $result = array(
                            'error' => false,
                            'msg' => 'เปลี่ยนที่อยู่อีเมล์แล้ว รอการยืนยันผ่านทางอีเมล์',
                            'url' => site_url('profile/index/' . $Id)
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

    private function upfileimages($Fild_Name,$Nember){

		$fileold = $this->input->post($Fild_Name.'_old');
		if(!empty($_FILES[$Fild_Name])){
			$new_name = $Nember;
			$config['upload_path'] = './uploads/student/';
			$config['allowed_types'] = '*';
			$config['file_name'] = $new_name;
			$config['max_size']	= '65000';
			$this->load->library('upload', $config ,'upbanner');
			$this->upbanner->initialize($config);
			if ( ! $this->upbanner->do_upload($Fild_Name)){
				$result = array(
					'error' => true,
					'title' => "Error",
					'msg' => $this->upbanner->display_errors()
				);
				echo json_encode($result);
				die;
			}else{
				if(!empty($fileold)){
					@unlink($config['upload_path'].$fileold);
				}
				$img = $this->upbanner->data();
				return $img['file_name'];
			}

		}else{
			return $fileold;
		}
    }
}
