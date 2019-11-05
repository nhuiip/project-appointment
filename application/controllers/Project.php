<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Project extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("project_model", "project");
        $this->load->model("projectfile_model", "projectfile");
        $this->load->model("student_model", "student");
        $this->load->model("subject_model", "subject");
        $this->load->model("meet_model", "meet");
        $this->load->model("administrator_model", "administrator");
        $this->load->model("conference_model", "conference");
    }

    public function index()
    {
        $permission = array("ผู้ดูแลระบบ", "หัวหน้าสาขา", "อาจารย์ผู้สอน");
        if (in_array($this->encryption->decrypt($this->input->cookie('sysp')), $permission)) {
            $data = array();

            $condition = array();
            $condition['fide'] = "*";
            $condition['orderby'] = "tb_project.project_id ASC";
            $data['listdata'] = $this->project->listjoinData2($condition);

            $this->template->backend('project/main', $data);
        } else {
            $this->load->view('errors/html/error_403');
        }
    }

    public function detail($id = "")
    {
        if (!empty($id)) {
            $permission = array("ผู้ดูแลระบบ", "หัวหน้าสาขา", "อาจารย์ผู้สอน");
            if (in_array($this->encryption->decrypt($this->input->cookie('sysp')), $permission)) {
                $data = array();

                $condition = array();
                $condition['fide'] = "*";
                $condition['where'] = array('tb_project.project_id' => $id);
                $data['listProject'] = $this->project->listjoinData2($condition);
                if (count($data['listProject']) != 0) {
                    $condition = array();
                    $condition['fide'] = "*";
                    $condition['where'] = array('tb_projectperson.project_id' => $id);
                    $data['listPerson'] = $this->project->listperson($condition);

                    $condition = array();
                    $condition['fide'] = "*";
                    $condition['where'] = array('tb_projectfile.project_id' => $id);
                    $condition['orderby'] = "tb_projectfile.file_name ASC";
                    $data['listFile'] = $this->projectfile->listjoinData($condition);

                    $condition = array();
                    $condition['fide'] = "*";
                    $condition['where'] = array('tb_conference.project_id' => $id);
                    $data['listCon'] = $this->conference->listjoinData($condition);

                    if (count($data['listCon']) != 0) {
                        $condition = array();
                        $condition['fide'] = "*";
                        $condition['where'] = array('conf_id' => $data['listCon'][0]['conf_id']);
                        $condition['orderby'] = "confpos_sort ASC";
                        $data['listConPerson'] = $this->conference->listPresonData($condition);
                    }

                    $condition = array();
                    $condition['fide'] = "*";
                    $data['listType'] = $this->conference->listtypeData($condition);

                    $data['status'] = array();
                    $data['status'][0] = array('project_status' => 1, 'text' => 'เริ่มต้น');
                    $data['status'][1] = array('project_status' => 2, 'text' => 'สอบหัวข้อปริญญานิพนธ์ (ผ่าน)');
                    $data['status'][2] = array('project_status' => 3, 'text' => 'สอบหัวข้อปริญญานิพนธ์ (ผ่านแบบมีเงื่อนไข)');
                    $data['status'][3] = array('project_status' => 4, 'text' => 'สอบหัวข้อปริญญานิพนธ์ (ตก)');
                    $data['status'][4] = array('project_status' => 5, 'text' => 'สอบป้องกันปริญญานิพนธ์ (Conference)');
                    $data['status'][5] = array('project_status' => 6, 'text' => 'สอบป้องกันปริญญานิพนธ์ (ผ่าน)');
                    $data['status'][6] = array('project_status' => 7, 'text' => 'สอบป้องกันปริญญานิพนธ์ (ผ่านแบบมีเงื่อนไข)');
                    $data['status'][7] = array('project_status' => 8, 'text' => 'สอบป้องกันปริญญานิพนธ์ (ตก)');
                } else {
                    show_404();
                }

                $this->template->backend('project/detail', $data);
            } else {
                $this->load->view('errors/html/error_403');
            }
        } else {
            show_404();
        }
    }

    public function loadfile($file_id = "", $useid = "")
    {


        //เช็คว่าในตาราง tb_trace มี use_id นี้อยู่ไหม & file_id นี้อยู่ไหม
        $condition = array();
        $condition['fide'] = "tb_trace.use_id,tb_projectfile.file_id,tb_projectfile.file_name,tb_projectfile.project_id";
        $condition['where'] = array('tb_trace.use_id' => $useid, 'tb_projectfile.file_id' => $file_id);
        $listproject = $this->projectfile->listjointrace($condition);

        //หากยังไม่มีการดาวน์โหลด ให้เพิ่มลงไป
        if (count($listproject) == 0) {

            $data = array(
                'file_id'          => $file_id,
                'use_id'           => $useid,
                'trace_datetime'   => date('Y-m-d H:i:s'),
            );
            $this->projectfile->insertFiletrace($data);
        } else if ($listproject[0]['use_id'] != $useid) {
            //เช็คค่าซ้ำ หากไม่ซ้ำ use_id ให้เพิ่มลงไป
            $data = array(
                'file_id'          => $file_id,
                'use_id'           => $useid,
                'trace_datetime'   => date('Y-m-d H:i:s'),
            );
            $this->projectfile->insertFiletrace($data);
        }

        // select ชื่อไฟล์ และ โฟลเดอร์
        $condition = array();
        $condition['fide'] = "tb_projectfile.file_id,tb_projectfile.file_name,tb_projectfile.project_id";
        $condition['where'] = array('tb_projectfile.file_id' => $file_id);
        $listproject = $this->projectfile->listData($condition);

        // redirect('uploads/fileproject/Project_' . $listproject[0]['project_id'] . '/' . $listproject[0]['file_name']);

        echo json_encode($listproject);
    }
    public function projectmeet($id = "")
    {
        $permission = array("หัวหน้าสาขา", "อาจารย์ผู้สอน");
        if (in_array($this->encryption->decrypt($this->input->cookie('sysp')), $permission)) {
            if (!empty($id)) {
                $condition = array();
                $condition['fide'] = "use_id, sub_id, sub_name, sub_code, sub_type";
                $condition['where'] = array('sub_id' => $id);
                $data['subject'] = $this->subject->listData($condition);
                if (count($data['subject']) != 0) {
                    if ($this->encryption->decrypt($this->input->cookie('sysli')) == $data['subject'][0]['use_id']) {
                        $condition = array();
                        $condition['fide'] = "meet_id, tb_meet.project_id, project_name, project_status, meet_time, meet_date";
                        $condition['where'] = array('tb_meet.sub_id' => $id, 'tb_meet.meet_status' => 1);
                        $data['listmeet'] = $this->meet->listjoinData($condition);

                        $data['status'] = array();
                        $data['status'][0] = array('project_status' => 1, 'text' => 'เริ่มต้น');
                        $data['status'][1] = array('project_status' => 2, 'text' => 'สอบหัวข้อปริญญานิพนธ์ (ผ่าน)');
                        $data['status'][2] = array('project_status' => 3, 'text' => 'สอบหัวข้อปริญญานิพนธ์ (ผ่านแบบมีเงื่อนไข)');
                        $data['status'][3] = array('project_status' => 4, 'text' => 'สอบหัวข้อปริญญานิพนธ์ (ตก)');
                        $data['status'][4] = array('project_status' => 5, 'text' => 'สอบป้องกันปริญญานิพนธ์ (Conference)');
                        $data['status'][5] = array('project_status' => 6, 'text' => 'สอบป้องกันปริญญานิพนธ์ (ผ่าน)');
                        $data['status'][6] = array('project_status' => 7, 'text' => 'สอบป้องกันปริญญานิพนธ์ (ผ่านแบบมีเงื่อนไข)');
                        $data['status'][7] = array('project_status' => 8, 'text' => 'สอบป้องกันปริญญานิพนธ์ (ตก)');

                        $data['sub_id'] = $data['subject'][0]['sub_id'];
                        $this->template->backend('project/projectmeet', $data);
                    } else {
                        $this->load->view('errors/html/error_403');
                    }
                } else {
                    show_404();
                }
            } else {
                show_404();
            }
        } else {
            $this->load->view('errors/html/error_403');
        }
    }
    public function updateData()
    {
        $data = array(
            'project_id'        => $this->input->post('project_id'),
            'project_status'    => $this->input->post('project_status'),
            'project_lastedit_name' => $this->encryption->decrypt($this->input->cookie('sysn')),
            'project_lastedit_date' => date('Y-m-d H:i:s'),
        );
        $this->project->updateData($data);

        $condition = array();
        $condition['fide'] = "tb_projectperson.std_id";
        $condition['where'] = array('tb_projectperson.project_id' => $this->input->post('project_id'));
        $person = $this->project->listjoinData($condition);

        if ($this->input->post('project_status') == 4 || $this->input->post('project_status') == 5) {
            foreach ($person as $key => $value) {
                $data = array(
                    'std_id' => $value['std_id'],
                    'std_status' => 1
                );
                $this->student->updateData($data);
            }
        } else {
            foreach ($person as $key => $value) {
                $data = array(
                    'std_id' => $value['std_id'],
                    'std_status' => 0
                );
                $this->student->updateData($data);
            }
        }

        if ($this->input->post('type') == 'projectmeet') {
            $url = site_url('project/projectmeet/' . $this->input->post('sub_id'));
        } elseif ($this->input->post('type') == 'projectdetail') {
            $url = site_url('project/detail/' . $this->input->post('project_id'));
        }
        $result = array(
            'error' => false,
            'msg' => 'แก้ไขข้อมูลสำเร็จ',
            'url' => $url
        );
        echo json_encode($result);
    }
}
