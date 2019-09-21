<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Project extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("project_model", "project");
        $this->load->model("student_model", "student");
        $this->load->model("subject_model", "subject");
    }

    public function index()
    {
        if($this->encryption->decrypt($this->input->cookie('sysp')) != 'นักศึกษา'){
            $this->load->view('errors/html/error_403');
        }else if($this->encryption->decrypt($this->input->cookie('sysp')) == 'นักศึกษา'){

            $condition = array();
            $condition['fide'] = "*";
            $data['listshowproject'] = $this->subject->listjoinData2($condition);
        
            $data['searchStdLogin'] = $this->subject->searchstdProject($this->encryption->decrypt($this->input->cookie('sysli')));

            $data['Id']         =   $this->encryption->decrypt($this->input->cookie('sysli'));   
            $data['position']   =   $this->encryption->decrypt($this->input->cookie('sysp'));   

            $data['formcrf'] = $this->tokens->token('formcrf');
            $this->template->backend('student/project', $data);

        }

    }

    public function addsubject($Id = ""){

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

                if($this->tokens->verify('crform')){
                    
                    $data = array(
                        'std_id'                => $this->input->post('Id'),
                        'project_name'          => $this->input->post('txt_projectname'),
                        'use_id'                => $this->input->post('use_id'),
                        'std_id'                => $this->input->post('Id'),
                        'project_status'        => '1',
                        'project_create_name'   => $this->encryption->decrypt($this->input->cookie('sysn')),
                        'project_create_date'   => date('Y-m-d H:i:s'),
                        'project_lastedit_name' => $this->encryption->decrypt($this->input->cookie('sysn')),
                        'project_lastedit_date' => date('Y-m-d H:i:s'),
                    );
                    
                    $Id = $this->project->insertData($data);
                        
                    $result = array(
                        'error' => false,
                        'msg' => 'เพิ่มข้อมูลเรียบร้อยแล้ว',
                        'url' => site_url('project/index/')
                    );
                    echo json_encode($result);
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

    public function addfile($Id = ""){

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

                if($this->tokens->verify('formcrf')){
                    
                    $data = array(
                        'projectId'                 => $this->input->post('project_id'),
                        'project_filecov'           => $this->input->upfileCOV('txt_01_cov'),
                        'project_filecer'           => $this->input->upfileCER('txt_02_cer'),
                        'project_fileabs'           => $this->input->upfileABS('txt_03_abs'),
                        'project_fileack'           => $this->input->upfileACK('txt_04_ack'),
                        'project_filetbc'           => $this->input->upfileTCB('txt_05_tcb'),
                        'project_filechone'         => $this->input->upfileCH01('txt_06_ch01'),
                        'project_filechtwo'         => $this->input->upfileCH02('txt_06_ch02'),
                        'project_filechthree'       => $this->input->upfileCH03('txt_06_ch03'),
                        'project_filechfour'        => $this->input->upfileCH04('txt_06_ch04'),
                        'project_filechfive'        => $this->input->upfileCH05('txt_06_ch05'),
                        'project_fileref'           => $this->input->upfileREF('txt_07_ref'),
                        'project_fileappone'        => $this->input->upfileAPP('txt_08_app'),
                        'project_filebio'           => $this->input->upfileBIO('txt_09_bio'),
                        'project_lastedit_name'     => $this->encryption->decrypt($this->input->cookie('sysn')),
                        'project_lastedit_date'     => date('Y-m-d H:i:s'),
                    );
                    

                    $this->project->updateData($data);

                    if(!empty($Id)){
                        $result = array(
                            'error' => false,
                            'msg' => 'อัพโหลดไฟล์เรียบร้อยแล้ว',
                            'url' => site_url('profile/index/'.$Id)
                        );
                        echo json_encode($result);
                    }else{
                        $result = array(
                            'error' => true,
                            'title' => "ล้มเหลว",
                            'msg' => 'อัพโหลดไฟล์ไม่สำเร็จ',
                        );
                        echo json_encode($result);
                    }
                    die;
                }else{
                    $result = array(
                        'error' => true,
                        'title' => "ล้มเหลว",
                        'msg' => "อัพโหลดไฟล์ไม่สำเร็จ"
                    );
                    
                    echo json_encode($result);
                }
            }
        }
    }

    private function upfileCOV($Fild_Name){
		$fileold = $this->input->post($Fild_Name.'_old');
		if(!empty($_FILES[$Fild_Name])){
			$new_name = time();
			$config['upload_path'] = './uploads/fileproject/';
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
