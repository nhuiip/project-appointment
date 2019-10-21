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
		$this->load->model("administrator_model", "administrator");
    }

    public function index($id = "")
    {
        $poslogin   = $this->encryption->decrypt($this->input->cookie('sysp'));
        $idlogin    = $this->encryption->decrypt($this->input->cookie('sysli'));

        if (!empty($this->encryption->decrypt($this->input->cookie('syslev')))) {
            if ($id == "") {
                show_404();
            } elseif ($poslogin == 'อาจารย์ผู้สอน' || $poslogin == 'หัวหน้าสาขา' || $poslogin == 'ผู้ดูแลระบบ') {
            
                $condition = array();
                $condition['fide'] = "use_id";
                $condition['where'] = array('use_id' => $id);
                $checkteacher= $this->administrator->listData($condition);
                if (count($checkteacher) == 0) {
                    show_404();
                } else {

                    $condition = array();
                    $condition['fide'] = "use_id,use_name";
                    $data['listuser'] = $this->administrator->listData($condition);

                    //============================================================//
                    $this->load->library('pagination');
                    $config['base_url'] = site_url('project/index/'.$id);
                    $config['total_rows'] = $this->project->count_all_news();
                    $config['per_page'] = 12;
                    $config['uri_segment'] = 3;
                    $choice = $config['total_rows'] / $config['per_page'];
                    $config['num_links'] = floor($choice);
                    $this->pagination->initialize($config);
                    $data['page'] = (!empty($_GET['page'])) ? $_GET['page'] : 0;

                    //product
                    $condition = array();
                    $condition['fide'] = "*";
                    $condition['limit'] = array($config['per_page'], $data['page']);
                    $condition['orderby'] = 'tb_project.project_create_date DESC';
                    $data['listproject'] = $this->project->listjoinData($condition);
                    $data['pagination'] = $this->pagination->create_links();

                    $condition = array();
                    $condition['fide'] = "*";
                    // $condition['orderby'] = "std_number DESC";
                    $data['listdata']= $this->project->listData($condition);

                    $this->template->backend('project/main', $data);

                }
            }else{
                show_404();
            }

        }

    }
    
    public function detail($id = "", $projectId="")
    {
        $poslogin   = $this->encryption->decrypt($this->input->cookie('sysp'));
        $idlogin    = $this->encryption->decrypt($this->input->cookie('sysli'));

        if (!empty($this->encryption->decrypt($this->input->cookie('syslev')))) {
            if ($id == "") {
                show_404();
            } else if ($poslogin == 'อาจารย์ผู้สอน' && $idlogin == $id || $poslogin == 'ผู้ดูแลระบบ' && $idlogin == $id) {
            
                $condition = array();
                $condition['fide'] = "use_id";
                $condition['where'] = array('use_id' => $idlogin);
                $checkteacher= $this->administrator->listData($condition);
                if (count($checkteacher) == 0) {
                    show_404();
                } else {

                    if($projectId == ""){
                        show_404();
                    }else{

                        $condition = array();
                        $condition['fide'] = "project_id";
                        $condition['where'] = array('project_id' => $projectId);
                        $checkproject= $this->project->listData($condition);
                        if (count($checkproject) == 0) {
                            show_404();
                        } else {

                            $data = array();

                            $condition = array();
                            $condition['fide'] = "tb_project.project_id,tb_project.project_name,tb_project.project_status,tb_subject.sub_id,tb_subject.sub_type,tb_subject.sub_code,tb_subject.sub_name,tb_user.use_name";
                            $condition['where'] = array('tb_project.project_id' => $projectId);
                            $data['showproject'] = $this->project->listjoinData2($condition);


                            $condition = array();
                            $condition['fide'] = "*";
                            $condition['where'] = array('project_id' => $id);
                            $data['showproject2'] = $this->project->listData($condition);

                            $this->template->backend('project/detail', $data);
                        }
                    }
                }

            }else{
                show_404();
            }

        }

    }

    public function search(){

		$condition = array();
        $condition['fide'] = "use_id,use_name";
        $data['listuser'] = $this->administrator->listData($condition);

        //============================================================//

		// Search text
		if($this->input->post('product_name') != NULL ){
			$search_text = $this->input->post('product_name');
		}else{
			$search_text = "";
		}

		$this->load->library('pagination');
        $config['base_url'] = site_url('project/index/'.$this->encryption->decrypt($this->input->cookie('sysli')));
		$config['total_rows'] = $this->project->getrecordCount($search_text);
        $config['per_page'] = 12;
        $config['uri_segment'] = 3;
        $choice = $config['total_rows'] / $config['per_page'];
        $config['num_links'] = floor($choice);
        $this->pagination->initialize($config);
        $data['page'] = (!empty($_GET['page'])) ? $_GET['page'] : 0;

		$users_record = $this->project->getData($data['page'],$config['per_page'],$search_text);
		$data['pagination'] = $this->pagination->create_links();
		$data['listproject'] = $users_record;
        
		$this->template->backend('project/main', $data);
    }

    public function searchstatus(){

		$condition = array();
        $condition['fide'] = "use_id,use_name";
        $data['listuser'] = $this->administrator->listData($condition);

        //============================================================//

		$search_text = $this->input->post('type');

		$this->load->library('pagination');
        $config['base_url'] = site_url('project/index/'.$this->encryption->decrypt($this->input->cookie('sysli')));
		$config['total_rows'] = $this->project->getrecordCountStatus($search_text);
        $config['per_page'] = 12;
        $config['uri_segment'] = 3;
        $choice = $config['total_rows'] / $config['per_page'];
        $config['num_links'] = floor($choice);
        $this->pagination->initialize($config);
        $data['page'] = (!empty($_GET['page'])) ? $_GET['page'] : 0;

		$users_record = $this->project->getDataStatus($data['page'],$config['per_page'],$search_text);
		$data['pagination'] = $this->pagination->create_links();
        $data['listproject'] = $users_record;

		$this->template->backend('project/main', $data);
    }

    public function searchteacher(){

		$condition = array();
        $condition['fide'] = "use_id,use_name";
        $data['listuser'] = $this->administrator->listData($condition);

        //============================================================//

		$search_text = $this->input->post('teacher');

		$this->load->library('pagination');
        $config['base_url'] = site_url('project/index/'.$this->encryption->decrypt($this->input->cookie('sysli')));
		$config['total_rows'] = $this->project->getrecordCountTeacher($search_text);
        $config['per_page'] = 12;
        $config['uri_segment'] = 3;
        $choice = $config['total_rows'] / $config['per_page'];
        $config['num_links'] = floor($choice);
        $this->pagination->initialize($config);
        $data['page'] = (!empty($_GET['page'])) ? $_GET['page'] : 0;

		$users_record = $this->project->getDataTeacher($data['page'],$config['per_page'],$search_text);
		$data['pagination'] = $this->pagination->create_links();
        $data['listproject'] = $users_record;

		$this->template->backend('project/main', $data);
    }

    public function addproject($Id = ""){

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

                    if($this->tokens->verify('formcrfaddproject')){
                        
                        if($this->input->post('radioInline3')==1){
                            $teacherId  =   $this->input->post('teacher_id');
                        }else{
                            $teacherId  =   $this->input->post('txt_teacher');
                        }

                        //================================================================ check radio [1=เดี่ยว, 2=กลุ่ม]
                        if($this->input->post('radioInline')==1){

                            $data = array(
                                'project_name'          => $this->input->post('txt_projectname'),
                                'use_id'                => $teacherId,
                                'std_id'                => $this->input->post('Idstd'),
                                'project_status'        => '1',
                                'project_create_name'   => $this->encryption->decrypt($this->input->cookie('sysn')),
                                'project_create_date'   => date('Y-m-d H:i:s'),
                                'project_lastedit_name' => $this->encryption->decrypt($this->input->cookie('sysn')),
                                'project_lastedit_date' => date('Y-m-d H:i:s'),
                            );
                            
                            $this->project->insertData($data);

                        }else{
                            $data = array(
                                'project_name'          => $this->input->post('txt_projectname'),
                                'use_id'                => $teacherId,
                                'std_id'                => $this->input->post('Idstd'),
                                'project_status'        => '1',
                                'project_create_name'   => $this->encryption->decrypt($this->input->cookie('sysn')),
                                'project_create_date'   => date('Y-m-d H:i:s'),
                                'project_lastedit_name' => $this->encryption->decrypt($this->input->cookie('sysn')),
                                'project_lastedit_date' => date('Y-m-d H:i:s'),
                            );

                            $Id_project  =   $this->project->insertData($data);

                            
                            $other = array();
                            for($i=0;$i<count($this->input->post('txt_std_id'));$i++){
                                $condition = array();
                                $condition['fide'] = "*";
                                $condition['where'] = array('project_id' => $Id_project);
                                $checkproject = $this->project->listData($condition);

                                $idstd  =   $checkproject[0]['std_id'];

                                $other['project_id'] 	= $Id_project;
                                $other['std_id'] 		= $idstd.','.$this->input->post('txt_std_id')[$i];

                                $this->project->updateData2($other);
                            }

                        }
                        //================================================================ ./check radio
                            
                        $result = array(
                            'error' => false,
                            'msg' => 'เพิ่มข้อมูลเรียบร้อยแล้ว',
                            'url' => site_url('project/index/'.$Id)
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
}
