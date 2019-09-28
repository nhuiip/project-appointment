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
        if($this->encryption->decrypt($this->encryption->decrypt($this->input->cookie('sysp'))) != 'นักศึกษา'){
            $this->load->view('errors/html/error_403');

        }else if($this->encryption->decrypt($this->encryption->decrypt($this->input->cookie('sysp'))) == 'นักศึกษา'){

            //แสดงข้อมูลรายวิชาที่ลงทะเบียนเรียน
            $condition = array();
            $condition['fide'] = "*";
            $data['listsubject'] = $this->subject->listjoinData2($condition);
        
            //ค้นหาโปรเจคที่นักศึกษาสร้างไว้
            $data['searchProject'] = $this->project->searchstdProject($this->encryption->decrypt($this->input->cookie('sysli')));

            $data['Id']         =   $this->encryption->decrypt($this->input->cookie('sysli'));   
            $data['position']   =   $this->encryption->decrypt($this->input->cookie('sysp'));   

            $search_text = $this->input->post('txt_search');

            $condition = array();
            $condition['fide'] = "*";
            $condition['where'] = array('std_number' => $search_text);
            $data['liststudent'] = $this->student->listData($condition);

            $data['formcrf'] = $this->tokens->token('formcrf');
            $this->template->backend('student/project', $data);

        }

    }

    public function updatestdproject($Id = "")
    {
        if($Id == ""){
            $this->load->view('errors/html/error_403');
        }else if($this->encryption->decrypt($this->input->cookie('sysp')) == 'นักศึกษา'){


            $condition = array();
            $condition['fide'] = "std_id";
            $condition['where'] = array('std_id' => $Id);
            $checkstudent = $this->project->listData($condition);
            if(count($checkstudent) == 0){
                $this->load->view('errors/html/error_403');
            }else{

                $condition = array();
                $condition['fide'] = "std_id";
                $condition['where'] = array('std_id' => $Id);
                $showstudent = $this->project->listData($condition);

                $project_id  =   $showstudent[0]['project_id'];
                $idstd       =   $showstudent[0]['std_id'];

                    $data = array(
                        'project_id'            => $project_id,
                        'std_id'                => $idstd,
                        'project_lastedit_name' => $this->encryption->decrypt($this->input->cookie('sysn')),
                        'project_lastedit_date' => date('Y-m-d H:i:s'),
                    );

                    $this->project->updateData($data);

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
                   
            }
        }
        

    }

    public function updatestdproject2($Id = "", $addstd = "")
    {
        if($Id == ""){
            $this->load->view('errors/html/error_403');
        }else if($this->encryption->decrypt($this->input->cookie('sysp')) == 'นักศึกษา'){


            $condition = array();
            $condition['fide'] = "std_id";
            $condition['where'] = array('std_id' => $Id);
            $checkstudent = $this->project->listData($condition);
            if(count($checkstudent) == 0){
                $this->load->view('errors/html/error_403');
            }else{

                // $search_text = "";
                if($addstd != NULL ){
                    $search_text = $addstd;
                    $this->session->set_userdata(array("search"=>$search_text));
                }else{
                    if($this->session->userdata('search') != NULL){
                        $search_text = $this->session->userdata('search');
                    }
                }

                if(!empty($search_text)){
                    $result = array(
                        'error' => false,
                        'msg' => 'แก้ไขข้อมูลสำเร็จ',
                        'url' => site_url('profile/index/'.$search_text)
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
                   
            }
        }
        

    }
    public function addproject($Id = ""){

        if($Id == ""){
            $this->load->view('errors/html/error_403');
        }else if($this->encryption->decrypt($this->encryption->decrypt($this->input->cookie('sysp'))) == 'นักศึกษา'){


                $condition = array();
                $condition['fide'] = "std_id";
                $condition['where'] = array('std_id' => $Id);
                $checkstudent = $this->student->listData($condition);
                if(count($checkstudent) == 0){
                    $this->load->view('errors/html/error_403');
                }else{

                    if($this->tokens->verify('crform')){
                        
                        $data = array(
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
    
    // uploadfile 01_cov
    public function add01_cov($Id = ""){

        if($Id == ""){
            $this->load->view('errors/html/error_403');
        }else if($this->encryption->decrypt($this->encryption->decrypt($this->input->cookie('sysp'))) == 'นักศึกษา'){

            $condition = array();
            $condition['fide'] = "std_id";
            $condition['where'] = array('std_id' => $Id);
            $checkstudent = $this->student->listData($condition);
            if(count($checkstudent) == 0){
                $this->load->view('errors/html/error_403');
            }else{

                if($this->tokens->verify('formcrf')){
                    
                    $Idproject =    $this->input->post('projectId');

                    $data = array(
                        'project_id'                => $Idproject,
                        'project_filecov'           => $this->upfileCOV('txt_01_cov',$Idproject),
                        'project_lastedit_name'     => $this->encryption->decrypt($this->input->cookie('sysn')),
                        'project_lastedit_date'     => date('Y-m-d H:i:s'),
                    );
                    

                    $this->project->updateData($data);

                    if(!empty($Id)){
                        $result = array(
                            'error' => false,
                            'msg' => 'อัพโหลดไฟล์เรียบร้อยแล้ว',
                            'url' => site_url('project/index/'.$Id)
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

    private function upfileCOV($Fild_Name, $Idproject){

		$fileold = $this->input->post($Fild_Name.'_old');
		if(!empty($_FILES[$Fild_Name])){
            $pathToUpload = './uploads/fileproject/' . $Idproject;
            if ( ! file_exists($pathToUpload) )
            {
                $create = mkdir($pathToUpload, 0777);
                if ( ! $create)
                return;

                $config['upload_path'] = $pathToUpload;

            }else{
                $config['upload_path'] = './uploads/fileproject/'.$Idproject;
            }
			$config['allowed_types'] = '*';
			$config['file_name'] = "01_cov";
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

    // uploadfile 02_cer
    public function add02_cer($Id = ""){

        if($Id == ""){
            $this->load->view('errors/html/error_403');
        }else if($this->encryption->decrypt($this->encryption->decrypt($this->input->cookie('sysp'))) == 'นักศึกษา'){

            $condition = array();
            $condition['fide'] = "std_id";
            $condition['where'] = array('std_id' => $Id);
            $checkstudent = $this->student->listData($condition);
            if(count($checkstudent) == 0){
                $this->load->view('errors/html/error_403');
            }else{

                if($this->tokens->verify('formcrf')){
                    
                    $Idproject =    $this->input->post('projectId');

                    $data = array(
                        'project_id'                => $Idproject,
                        'project_filecer'           => $this->upfileCER('txt_02_cer',$Idproject),
                        'project_lastedit_name'     => $this->encryption->decrypt($this->input->cookie('sysn')),
                        'project_lastedit_date'     => date('Y-m-d H:i:s'),
                    );
                    

                    $this->project->updateData($data);

                    if(!empty($Id)){
                        $result = array(
                            'error' => false,
                            'msg' => 'อัพโหลดไฟล์เรียบร้อยแล้ว',
                            'url' => site_url('project/index/'.$Id)
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

    private function upfileCER($Fild_Name, $Idproject){

		$fileold = $this->input->post($Fild_Name.'_old');
		if(!empty($_FILES[$Fild_Name])){
            $pathToUpload = './uploads/fileproject/' . $Idproject;
            if ( ! file_exists($pathToUpload) )
            {
                $create = mkdir($pathToUpload, 0777);
                if ( ! $create)
                return;

                $config['upload_path'] = $pathToUpload;

            }else{
                $config['upload_path'] = './uploads/fileproject/'.$Idproject;
            }
			$config['allowed_types'] = '*';
			$config['file_name'] = "02_cer";
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

    // uploadfile 03_abs
    public function add03_abs($Id = ""){

        if($Id == ""){
            $this->load->view('errors/html/error_403');
        }else if($this->encryption->decrypt($this->encryption->decrypt($this->input->cookie('sysp'))) == 'นักศึกษา'){

            $condition = array();
            $condition['fide'] = "std_id";
            $condition['where'] = array('std_id' => $Id);
            $checkstudent = $this->student->listData($condition);
            if(count($checkstudent) == 0){
                $this->load->view('errors/html/error_403');
            }else{

                if($this->tokens->verify('formcrf')){
                    
                    $Idproject =    $this->input->post('projectId');

                    $data = array(
                        'project_id'                => $Idproject,
                        'project_fileabs'           => $this->upfileABS('txt_03_abs',$Idproject),
                        'project_lastedit_name'     => $this->encryption->decrypt($this->input->cookie('sysn')),
                        'project_lastedit_date'     => date('Y-m-d H:i:s'),
                    );
                    

                    $this->project->updateData($data);

                    if(!empty($Id)){
                        $result = array(
                            'error' => false,
                            'msg' => 'อัพโหลดไฟล์เรียบร้อยแล้ว',
                            'url' => site_url('project/index/'.$Id)
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

    private function upfileABS($Fild_Name, $Idproject){

		$fileold = $this->input->post($Fild_Name.'_old');
		if(!empty($_FILES[$Fild_Name])){
            $pathToUpload = './uploads/fileproject/' . $Idproject;
            if ( ! file_exists($pathToUpload) )
            {
                $create = mkdir($pathToUpload, 0777);
                if ( ! $create)
                return;

                $config['upload_path'] = $pathToUpload;

            }else{
                $config['upload_path'] = './uploads/fileproject/'.$Idproject;
            }
			$config['allowed_types'] = '*';
			$config['file_name'] = "03_abs";
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

    // uploadfile 04_ack
    public function add04_ack($Id = ""){

        if($Id == ""){
            $this->load->view('errors/html/error_403');
        }else if($this->encryption->decrypt($this->encryption->decrypt($this->input->cookie('sysp'))) == 'นักศึกษา'){

            $condition = array();
            $condition['fide'] = "std_id";
            $condition['where'] = array('std_id' => $Id);
            $checkstudent = $this->student->listData($condition);
            if(count($checkstudent) == 0){
                $this->load->view('errors/html/error_403');
            }else{

                if($this->tokens->verify('formcrf')){
                    
                    $Idproject =    $this->input->post('projectId');

                    $data = array(
                        'project_id'                => $Idproject,
                        'project_fileack'           => $this->upfileACK('txt_04_ack',$Idproject),
                        'project_lastedit_name'     => $this->encryption->decrypt($this->input->cookie('sysn')),
                        'project_lastedit_date'     => date('Y-m-d H:i:s'),
                    );
                    

                    $this->project->updateData($data);

                    if(!empty($Id)){
                        $result = array(
                            'error' => false,
                            'msg' => 'อัพโหลดไฟล์เรียบร้อยแล้ว',
                            'url' => site_url('project/index/'.$Id)
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

    private function upfileACK($Fild_Name, $Idproject){

		$fileold = $this->input->post($Fild_Name.'_old');
		if(!empty($_FILES[$Fild_Name])){
            $pathToUpload = './uploads/fileproject/' . $Idproject;
            if ( ! file_exists($pathToUpload) )
            {
                $create = mkdir($pathToUpload, 0777);
                if ( ! $create)
                return;

                $config['upload_path'] = $pathToUpload;

            }else{
                $config['upload_path'] = './uploads/fileproject/'.$Idproject;
            }
			$config['allowed_types'] = '*';
			$config['file_name'] = "04_ack";
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

    // uploadfile 05_tcb
    public function add05_tcb($Id = ""){

        if($Id == ""){
            $this->load->view('errors/html/error_403');
        }else if($this->encryption->decrypt($this->encryption->decrypt($this->input->cookie('sysp'))) == 'นักศึกษา'){

            $condition = array();
            $condition['fide'] = "std_id";
            $condition['where'] = array('std_id' => $Id);
            $checkstudent = $this->student->listData($condition);
            if(count($checkstudent) == 0){
                $this->load->view('errors/html/error_403');
            }else{

                if($this->tokens->verify('formcrf')){
                    
                    $Idproject =    $this->input->post('projectId');

                    $data = array(
                        'project_id'                => $Idproject,
                        'project_filetbc'           => $this->upfileTCB('txt_05_tcb',$Idproject),
                        'project_lastedit_name'     => $this->encryption->decrypt($this->input->cookie('sysn')),
                        'project_lastedit_date'     => date('Y-m-d H:i:s'),
                    );
                    

                    $this->project->updateData($data);

                    if(!empty($Id)){
                        $result = array(
                            'error' => false,
                            'msg' => 'อัพโหลดไฟล์เรียบร้อยแล้ว',
                            'url' => site_url('project/index/'.$Id)
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
    
    private function upfileTCB($Fild_Name, $Idproject){

		$fileold = $this->input->post($Fild_Name.'_old');
		if(!empty($_FILES[$Fild_Name])){
            $pathToUpload = './uploads/fileproject/' . $Idproject;
            if ( ! file_exists($pathToUpload) )
            {
                $create = mkdir($pathToUpload, 0777);
                if ( ! $create)
                return;

                $config['upload_path'] = $pathToUpload;

            }else{
                $config['upload_path'] = './uploads/fileproject/'.$Idproject;
            }
			$config['allowed_types'] = '*';
			$config['file_name'] = "05_tcb";
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

    // uploadfile 06_ch01
    public function add06_ch01($Id = ""){

        if($Id == ""){
            $this->load->view('errors/html/error_403');
        }else if($this->encryption->decrypt($this->encryption->decrypt($this->input->cookie('sysp'))) == 'นักศึกษา'){

            $condition = array();
            $condition['fide'] = "std_id";
            $condition['where'] = array('std_id' => $Id);
            $checkstudent = $this->student->listData($condition);
            if(count($checkstudent) == 0){
                $this->load->view('errors/html/error_403');
            }else{

                if($this->tokens->verify('formcrf')){
                    
                    $Idproject =    $this->input->post('projectId');

                    $data = array(
                        'project_id'                => $Idproject,
                        'project_filechone'         => $this->upfileCH01('txt_06_ch01',$Idproject),
                        'project_lastedit_name'     => $this->encryption->decrypt($this->input->cookie('sysn')),
                        'project_lastedit_date'     => date('Y-m-d H:i:s'),
                    );
                    

                    $this->project->updateData($data);

                    if(!empty($Id)){
                        $result = array(
                            'error' => false,
                            'msg' => 'อัพโหลดไฟล์เรียบร้อยแล้ว',
                            'url' => site_url('project/index/'.$Id)
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
    
    private function upfileCH01($Fild_Name, $Idproject){

		$fileold = $this->input->post($Fild_Name.'_old');
		if(!empty($_FILES[$Fild_Name])){
            $pathToUpload = './uploads/fileproject/' . $Idproject;
            if ( ! file_exists($pathToUpload) )
            {
                $create = mkdir($pathToUpload, 0777);
                if ( ! $create)
                return;

                $config['upload_path'] = $pathToUpload;

            }else{
                $config['upload_path'] = './uploads/fileproject/'.$Idproject;
            }
			$config['allowed_types'] = '*';
			$config['file_name'] = "06_ch01";
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

    // uploadfile 06_ch02
    public function add06_ch02($Id = ""){

        if($Id == ""){
            $this->load->view('errors/html/error_403');
        }else if($this->encryption->decrypt($this->encryption->decrypt($this->input->cookie('sysp'))) == 'นักศึกษา'){

            $condition = array();
            $condition['fide'] = "std_id";
            $condition['where'] = array('std_id' => $Id);
            $checkstudent = $this->student->listData($condition);
            if(count($checkstudent) == 0){
                $this->load->view('errors/html/error_403');
            }else{

                if($this->tokens->verify('formcrf')){
                    
                    $Idproject =    $this->input->post('projectId');

                    $data = array(
                        'project_id'                => $Idproject,
                        'project_filechtwo'         => $this->upfileCH02('txt_06_ch02',$Idproject),
                        'project_lastedit_name'     => $this->encryption->decrypt($this->input->cookie('sysn')),
                        'project_lastedit_date'     => date('Y-m-d H:i:s'),
                    );
                    

                    $this->project->updateData($data);

                    if(!empty($Id)){
                        $result = array(
                            'error' => false,
                            'msg' => 'อัพโหลดไฟล์เรียบร้อยแล้ว',
                            'url' => site_url('project/index/'.$Id)
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
    
    private function upfileCH02($Fild_Name, $Idproject){

		$fileold = $this->input->post($Fild_Name.'_old');
		if(!empty($_FILES[$Fild_Name])){
            $pathToUpload = './uploads/fileproject/' . $Idproject;
            if ( ! file_exists($pathToUpload) )
            {
                $create = mkdir($pathToUpload, 0777);
                if ( ! $create)
                return;

                $config['upload_path'] = $pathToUpload;

            }else{
                $config['upload_path'] = './uploads/fileproject/'.$Idproject;
            }
			$config['allowed_types'] = '*';
			$config['file_name'] = "06_ch02";
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

    // uploadfile 06_ch03
    public function add06_ch03($Id = ""){

        if($Id == ""){
            $this->load->view('errors/html/error_403');
        }else if($this->encryption->decrypt($this->encryption->decrypt($this->input->cookie('sysp'))) == 'นักศึกษา'){

            $condition = array();
            $condition['fide'] = "std_id";
            $condition['where'] = array('std_id' => $Id);
            $checkstudent = $this->student->listData($condition);
            if(count($checkstudent) == 0){
                $this->load->view('errors/html/error_403');
            }else{

                if($this->tokens->verify('formcrf')){
                    
                    $Idproject =    $this->input->post('projectId');

                    $data = array(
                        'project_id'                => $Idproject,
                        'project_filechthree'       => $this->upfileCH03('txt_06_ch03',$Idproject),
                        'project_lastedit_name'     => $this->encryption->decrypt($this->input->cookie('sysn')),
                        'project_lastedit_date'     => date('Y-m-d H:i:s'),
                    );
                    

                    $this->project->updateData($data);

                    if(!empty($Id)){
                        $result = array(
                            'error' => false,
                            'msg' => 'อัพโหลดไฟล์เรียบร้อยแล้ว',
                            'url' => site_url('project/index/'.$Id)
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
    
    private function upfileCH03($Fild_Name, $Idproject){

		$fileold = $this->input->post($Fild_Name.'_old');
		if(!empty($_FILES[$Fild_Name])){
            $pathToUpload = './uploads/fileproject/' . $Idproject;
            if ( ! file_exists($pathToUpload) )
            {
                $create = mkdir($pathToUpload, 0777);
                if ( ! $create)
                return;

                $config['upload_path'] = $pathToUpload;

            }else{
                $config['upload_path'] = './uploads/fileproject/'.$Idproject;
            }
			$config['allowed_types'] = '*';
			$config['file_name'] = "06_ch03";
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

    // uploadfile 06_ch04
    public function add06_ch04($Id = ""){

        if($Id == ""){
            $this->load->view('errors/html/error_403');
        }else if($this->encryption->decrypt($this->encryption->decrypt($this->input->cookie('sysp'))) == 'นักศึกษา'){

            $condition = array();
            $condition['fide'] = "std_id";
            $condition['where'] = array('std_id' => $Id);
            $checkstudent = $this->student->listData($condition);
            if(count($checkstudent) == 0){
                $this->load->view('errors/html/error_403');
            }else{

                if($this->tokens->verify('formcrf')){
                    
                    $Idproject =    $this->input->post('projectId');

                    $data = array(
                        'project_id'                => $Idproject,
                        'project_filechfour'        => $this->upfileCH04('txt_06_ch04',$Idproject),
                        'project_lastedit_name'     => $this->encryption->decrypt($this->input->cookie('sysn')),
                        'project_lastedit_date'     => date('Y-m-d H:i:s'),
                    );
                    

                    $this->project->updateData($data);

                    if(!empty($Id)){
                        $result = array(
                            'error' => false,
                            'msg' => 'อัพโหลดไฟล์เรียบร้อยแล้ว',
                            'url' => site_url('project/index/'.$Id)
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
    
    private function upfileCH04($Fild_Name, $Idproject){

		$fileold = $this->input->post($Fild_Name.'_old');
		if(!empty($_FILES[$Fild_Name])){
            $pathToUpload = './uploads/fileproject/' . $Idproject;
            if ( ! file_exists($pathToUpload) )
            {
                $create = mkdir($pathToUpload, 0777);
                if ( ! $create)
                return;

                $config['upload_path'] = $pathToUpload;

            }else{
                $config['upload_path'] = './uploads/fileproject/'.$Idproject;
            }
			$config['allowed_types'] = '*';
			$config['file_name'] = "06_ch04";
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

    // uploadfile 06_ch05
    public function add06_ch05($Id = ""){

        if($Id == ""){
            $this->load->view('errors/html/error_403');
        }else if($this->encryption->decrypt($this->encryption->decrypt($this->input->cookie('sysp'))) == 'นักศึกษา'){

            $condition = array();
            $condition['fide'] = "std_id";
            $condition['where'] = array('std_id' => $Id);
            $checkstudent = $this->student->listData($condition);
            if(count($checkstudent) == 0){
                $this->load->view('errors/html/error_403');
            }else{

                if($this->tokens->verify('formcrf')){
                    
                    $Idproject =    $this->input->post('projectId');

                    $data = array(
                        'project_id'                => $Idproject,
                        'project_filechfive'        => $this->upfileCH05('txt_06_ch05',$Idproject),
                        'project_lastedit_name'     => $this->encryption->decrypt($this->input->cookie('sysn')),
                        'project_lastedit_date'     => date('Y-m-d H:i:s'),
                    );
                    

                    $this->project->updateData($data);

                    if(!empty($Id)){
                        $result = array(
                            'error' => false,
                            'msg' => 'อัพโหลดไฟล์เรียบร้อยแล้ว',
                            'url' => site_url('project/index/'.$Id)
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
    
    private function upfileCH05($Fild_Name, $Idproject){

		$fileold = $this->input->post($Fild_Name.'_old');
		if(!empty($_FILES[$Fild_Name])){
            $pathToUpload = './uploads/fileproject/' . $Idproject;
            if ( ! file_exists($pathToUpload) )
            {
                $create = mkdir($pathToUpload, 0777);
                if ( ! $create)
                return;

                $config['upload_path'] = $pathToUpload;

            }else{
                $config['upload_path'] = './uploads/fileproject/'.$Idproject;
            }
			$config['allowed_types'] = '*';
			$config['file_name'] = "06_ch05";
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

    // uploadfile 07_ref
    public function add07_ref($Id = ""){

        if($Id == ""){
            $this->load->view('errors/html/error_403');
        }else if($this->encryption->decrypt($this->encryption->decrypt($this->input->cookie('sysp'))) == 'นักศึกษา'){

            $condition = array();
            $condition['fide'] = "std_id";
            $condition['where'] = array('std_id' => $Id);
            $checkstudent = $this->student->listData($condition);
            if(count($checkstudent) == 0){
                $this->load->view('errors/html/error_403');
            }else{

                if($this->tokens->verify('formcrf')){
                    
                    $Idproject =    $this->input->post('projectId');

                    $data = array(
                        'project_id'                => $Idproject,
                        'project_fileref'           => $this->upfileREF('txt_07_ref',$Idproject),
                        'project_lastedit_name'     => $this->encryption->decrypt($this->input->cookie('sysn')),
                        'project_lastedit_date'     => date('Y-m-d H:i:s'),
                    );
                    

                    $this->project->updateData($data);

                    if(!empty($Id)){
                        $result = array(
                            'error' => false,
                            'msg' => 'อัพโหลดไฟล์เรียบร้อยแล้ว',
                            'url' => site_url('project/index/'.$Id)
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
    
    private function upfileREF($Fild_Name, $Idproject){

		$fileold = $this->input->post($Fild_Name.'_old');
		if(!empty($_FILES[$Fild_Name])){
            $pathToUpload = './uploads/fileproject/' . $Idproject;
            if ( ! file_exists($pathToUpload) )
            {
                $create = mkdir($pathToUpload, 0777);
                if ( ! $create)
                return;

                $config['upload_path'] = $pathToUpload;

            }else{
                $config['upload_path'] = './uploads/fileproject/'.$Idproject;
            }
			$config['allowed_types'] = '*';
			$config['file_name'] = "07_ref";
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

    // uploadfile 08_app
    public function add08_app($Id = ""){

        if($Id == ""){
            $this->load->view('errors/html/error_403');
        }else if($this->encryption->decrypt($this->encryption->decrypt($this->input->cookie('sysp'))) == 'นักศึกษา'){

            $condition = array();
            $condition['fide'] = "std_id";
            $condition['where'] = array('std_id' => $Id);
            $checkstudent = $this->student->listData($condition);
            if(count($checkstudent) == 0){
                $this->load->view('errors/html/error_403');
            }else{

                if($this->tokens->verify('formcrf')){
                    
                    $Idproject =    $this->input->post('projectId');

                    $data = array(
                        'project_id'                => $Idproject,
                        'project_fileappone'        => $this->upfileAPP('txt_08_app',$Idproject),
                        'project_lastedit_name'     => $this->encryption->decrypt($this->input->cookie('sysn')),
                        'project_lastedit_date'     => date('Y-m-d H:i:s'),
                    );
                    

                    $this->project->updateData($data);

                    if(!empty($Id)){
                        $result = array(
                            'error' => false,
                            'msg' => 'อัพโหลดไฟล์เรียบร้อยแล้ว',
                            'url' => site_url('project/index/'.$Id)
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
    
    private function upfileAPP($Fild_Name, $Idproject){

		$fileold = $this->input->post($Fild_Name.'_old');
		if(!empty($_FILES[$Fild_Name])){
            $pathToUpload = './uploads/fileproject/' . $Idproject;
            if ( ! file_exists($pathToUpload) )
            {
                $create = mkdir($pathToUpload, 0777);
                if ( ! $create)
                return;

                $config['upload_path'] = $pathToUpload;

            }else{
                $config['upload_path'] = './uploads/fileproject/'.$Idproject;
            }
			$config['allowed_types'] = '*';
			$config['file_name'] = "08_app";
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

    // uploadfile 09_bio
    public function add09_bio($Id = ""){

        if($Id == ""){
            $this->load->view('errors/html/error_403');
        }else if($this->encryption->decrypt($this->encryption->decrypt($this->input->cookie('sysp'))) == 'นักศึกษา'){

            $condition = array();
            $condition['fide'] = "std_id";
            $condition['where'] = array('std_id' => $Id);
            $checkstudent = $this->student->listData($condition);
            if(count($checkstudent) == 0){
                $this->load->view('errors/html/error_403');
            }else{

                if($this->tokens->verify('formcrf')){
                    
                    $Idproject =    $this->input->post('projectId');

                    $data = array(
                        'project_id'                => $Idproject,
                        'project_filebio'           => $this->upfileBIO('txt_09_bio',$Idproject),
                        'project_lastedit_name'     => $this->encryption->decrypt($this->input->cookie('sysn')),
                        'project_lastedit_date'     => date('Y-m-d H:i:s'),
                    );
                    

                    $this->project->updateData($data);

                    if(!empty($Id)){
                        $result = array(
                            'error' => false,
                            'msg' => 'อัพโหลดไฟล์เรียบร้อยแล้ว',
                            'url' => site_url('project/index/'.$Id)
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
    
    private function upfileBIO($Fild_Name, $Idproject){

		$fileold = $this->input->post($Fild_Name.'_old');
		if(!empty($_FILES[$Fild_Name])){
            $pathToUpload = './uploads/fileproject/' . $Idproject;
            if ( ! file_exists($pathToUpload) )
            {
                $create = mkdir($pathToUpload, 0777);
                if ( ! $create)
                return;

                $config['upload_path'] = $pathToUpload;

            }else{
                $config['upload_path'] = './uploads/fileproject/'.$Idproject;
            }
			$config['allowed_types'] = '*';
			$config['file_name'] = "09_bio";
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
