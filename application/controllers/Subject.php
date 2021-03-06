<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Subject extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("subject_model", "subject");
        $this->load->model("setting_model", "setting");
        $this->load->model("attached_model", "attached");
        $this->load->model("administrator_model", "administrator");
    }

    public function index()
    {
        $permission = array("ผู้ดูแลระบบ", "หัวหน้าสาขา", "อาจารย์ผู้สอน");
        if (in_array($this->encryption->decrypt($this->input->cookie('sysp')), $permission)) {
            $data = array();
            $condition = array();
            $condition['fide'] = "*";
            $condition['orderby'] = "tb_subject.sub_id DESC ";
            $data['listdata'] = $this->subject->listjoinData($condition);

            $condition = array();
            $condition['fide'] = "set_status, set_id";
            $condition['where'] = array('set_status' => 2);
            $checkinsert = $this->setting->listData($condition);

            $arrposition = array(2, 3);
            $condition = array();
            $condition['fide'] = "*";
            $condition['where_in']['filde'] = 'position_id';
            $condition['where_in']['value'] = $arrposition;
            $data['user'] = $this->administrator->listData($condition);

            $arrposition = array(2, 3);
            $condition = array();
            $condition['fide'] = "*";
            $condition['where_in']['filde'] = 'position_id';
            $condition['where_in']['value'] = $arrposition;
            $condition['orderby'] = "use_name ASC ";
            $data['user'] = $this->administrator->listData($condition);

            $data['formcrf'] = $this->tokens->token('formcrf');
            $this->template->backend('subject/main', $data);
        } else {
            $this->load->view('errors/html/error_403');
        }
    }

    public function detail($id = "")
    {
        $permission = array("ผู้ดูแลระบบ", "หัวหน้าสาขา", "อาจารย์ผู้สอน");
        if (in_array($this->encryption->decrypt($this->input->cookie('sysp')), $permission)) {
            if (!empty($id)) {

                $condition = array();
                $condition['fide'] = "*";
                $condition['where'] = array('tb_subject.sub_id' => $id);
                $data['listsubject'] = $this->subject->listjoinData($condition);

                if (count($data['listsubject']) == 0) {
                    show_404();
                }

                $condition = array();
                $condition['fide'] = "*";
                $condition['where'] = array('sub_id' => $data['listsubject'][0]['sub_id']);
                $condition['orderby'] = "att_name ASC ";
                $data['listatt'] = $this->attached->listData($condition);

                $arrposition = array(2, 3);
                $condition = array();
                $condition['fide'] = "*";
                $condition['where_in']['filde'] = 'position_id';
                $condition['where_in']['value'] = $arrposition;
                $condition['orderby'] = "use_name ASC ";
                $data['user'] = $this->administrator->listData($condition);

                $data['formcrf'] = $this->tokens->token('formcrf');
                $this->template->backend('subject/detail', $data);
            } else {
                show_404();
            }
        } else {
            $this->load->view('errors/html/error_403');
        }
    }

    public function create()
    {
        if ($this->tokens->verify('formcrf')) {
            $data = array(
                'sub_name'          => $this->input->post('sub_name'),
                'sub_code'          => $this->input->post('sub_code'),
                'use_id'            => $this->input->post('use_id'),
                'sub_setuse'        => $this->input->post('sub_setuse'),
                'sub_setless'       => $this->input->post('sub_setless'),
                'sub_type'          => $this->input->post('sub_type'),
                'sub_status'        => 1,
                'sub_create_name'   => $this->encryption->decrypt($this->input->cookie('sysn')),
                'sub_create_date'   => date('Y-m-d H:i:s'),
                'sub_lastedit_name' => $this->encryption->decrypt($this->input->cookie('sysn')),
                'sub_lastedit_date' => date('Y-m-d H:i:s'),
            );
            $this->subject->insertData($data);
            $result = array(
                'error' => false,
                'msg' => 'เพิ่มข้อมูลสำเร็จ',
                'url' => site_url('subject/index')
            );
            echo json_encode($result);
        }
    }

    public function update()
    {
        if ($this->tokens->verify('formcrf')) {
            $data = array(
                'sub_id'            => $this->input->post('Id'),
                'sub_name'          => $this->input->post('sub_name'),
                'sub_code'          => $this->input->post('sub_code'),
                'use_id'            => $this->input->post('use_id'),
                'sub_setuse'        => $this->input->post('sub_setuse'),
                'sub_setless'       => $this->input->post('sub_setless'),
                'sub_type'          => $this->input->post('sub_type'),
                'sub_lastedit_name' => $this->encryption->decrypt($this->input->cookie('sysn')),
                'sub_lastedit_date' => date('Y-m-d H:i:s'),
            );
            $this->subject->updateData($data);
            $result = array(
                'error' => false,
                'msg' => 'แก้ไขข้อมูลสำเร็จ',
                'url' => site_url('subject/detail/'.$this->input->post('Id'))
            );
            echo json_encode($result);
        }
    }

    public function updateclose($sub_id = "")
    {
        if ($sub_id == "") {
            show_404();
        } else {
            $data = array(
                'sub_id'            => $sub_id,
                'sub_status'          => 0,
                'sub_lastedit_name' => $this->encryption->decrypt($this->input->cookie('sysn')),
                'sub_lastedit_date' => date('Y-m-d H:i:s'),
            );
            $this->subject->updateData($data);
            header("location:" . site_url('subject/index'));
        }
    }

    public function updateopen($sub_id = "")
    {
        if ($sub_id == "") {
            show_404();
        } else {
            $data = array(
                'sub_id'            => $sub_id,
                'sub_status'          => 1,
                'sub_lastedit_name' => $this->encryption->decrypt($this->input->cookie('sysn')),
                'sub_lastedit_date' => date('Y-m-d H:i:s'),
            );
            $this->subject->updateData($data);
            header("location:" . site_url('subject/index'));
        }
    }

    public function delete($id = '')
    {
        $data = array(
            'sub_id'            => $id,
        );
        $this->subject->deleteData($data);
        header("location:" . site_url('subject/index'));
    }
}
