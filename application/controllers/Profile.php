<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Profile extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("student_model", "student");
        $this->load->model("subject_model", "subject");
    }

    public function index($loginid = "")
    {

        if($loginid == ""){
            $this->load->view('errors/html/error_403');
        }else if($this->encryption->decrypt($this->input->cookie('sysp')) == 'นักศึกษา'){


            $condition = array();
            $condition['fide'] = "std_id";
            $condition['where'] = array('std_id' => $loginid);
            $checkstudent = $this->student->listData($condition);
            if(count($checkstudent) == 0){
                $this->load->view('errors/html/error_403');
            }else{

                $condition = array();
                $condition['fide'] = "*";
                $data['liststudent'] = $this->student->listjoinData($condition);

                $condition = array();
                $condition['fide'] = "*";
                $data['listsubject'] = $this->subject->listData($condition);
    
                $data['formcrf'] = $this->tokens->token('formcrf');
                $this->template->backend('student/profile', $data);

            }
        }

       

    }

    public function update($Id = "")
    {
        if($Id == ""){
            $this->load->view('errors/html/error_403');
        }else if($this->encryption->decrypt($this->input->cookie('sysp')) == 'นักศึกษา'){


            $condition = array();
            $condition['fide'] = "std_id";
            $condition['where'] = array('std_id' => $Id);
            $checkstudent = $this->student->listData($condition);
            if(count($checkstudent) == 0){
                $this->load->view('errors/html/error_403');
            }else{

                if ($this->tokens->verify('formcrf')) {
                    $data = array(
                        'std_id'                => $this->input->post('Id'),
                        'std_img'               => $this->upfileimages('std_img'),
                        'std_fname'             => $this->input->post('text_name'),
                        'std_lname'             => $this->input->post('text_lastname'),
                        // 'std_email'             => $this->input->post('text_email'),
                        'std_tel'               => $this->input->post('text_tel'),
                        // 'std_pass'               => md5($this->input->post('text_password')),
                        'std_lastedit_name'     => $this->encryption->decrypt($this->input->cookie('sysn')),
                        'std_lastedit_date'     => date('Y-m-d H:i:s'),
                    );

                    $this->student->updateStd($data);

                    if(!empty($Id)){
                        $result = array(
                            'error' => false,
                            'msg' => 'แก้ไขข้อมูลสำเร็จ',
                            'url' => site_url('profile/index/'.$Id)
                        );
                        echo json_encode($result);
                    }else{
                        $result = array(
                            'error' => true,
                            'title' => "ล้มเหลว",
                            'msg' => 'อัพเดตข้อมูลไม่สำเร็จ',
                        );
                        echo json_encode($result);
                    }
                    die;
                }else{
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
        if($Id == ""){
            $this->load->view('errors/html/error_403');
        }else if($this->encryption->decrypt($this->input->cookie('sysp')) == 'นักศึกษา'){


            $condition = array();
            $condition['fide'] = "std_id";
            $condition['where'] = array('std_id' => $Id);
            $checkstudent = $this->student->listData($condition);
            if(count($checkstudent) == 0){
                $this->load->view('errors/html/error_403');
            }else{

                if ($this->tokens->verify('formcrf')) {
                    $data = array(
                        'std_id'                => $this->input->post('Id'),
                        'std_emailchang'             => $this->input->post('text_email'),
                        'std_lastedit_name'     => $this->encryption->decrypt($this->input->cookie('sysn')),
                        'std_lastedit_date'     => date('Y-m-d H:i:s'),
                    );

                    $this->student->updateStd($data);

                    if(!empty($Id)){
                        $result = array(
                            'error' => false,
                            'msg' => 'เปลี่ยนที่อยู่อีเมล์แล้ว รอการยืนยันผ่านทางอีเมล์',
                            'url' => site_url('profile/index/'.$Id)
                        );
                        echo json_encode($result);
                    }else{
                        $result = array(
                            'error' => true,
                            'title' => "ล้มเหลว",
                            'msg' => 'เปลี่ยนที่อยู่อีเมล์ไม่สำเร็จ',
                        );
                        echo json_encode($result);
                    }
                    die;
                }else{
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

    private function upfileimages($Fild_Name){
		$fileold = $this->input->post($Fild_Name.'_old');
		if(!empty($_FILES[$Fild_Name])){
			$new_name = time();
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