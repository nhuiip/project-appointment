<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Subject extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("subject_model", "subject");
        $this->load->model("setting_model", "setting");
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

            if (count($checkinsert) == 1) {
                $data['checkinsert'] = 'yes';
                
                $arrposition = array(2, 3);
                $condition = array();
                $condition['fide'] = "*";
                $condition['where_in']['filde'] = 'position_id';
                $condition['where_in']['value'] = $arrposition;
                $data['user'] = $this->administrator->listData($condition);
            } else {
                $data['checkinsert'] = 'no';
            }

            $data['formcrf'] = $this->tokens->token('formcrf');
            $this->template->backend('subject/main', $data);
        } else {
            $this->load->view('errors/html/error_403');
        }
    }

    public function form($id = "")
    {
        $permission = array("ผู้ดูแลระบบ", "หัวหน้าสาขา", "อาจารย์ผู้สอน");
        if (in_array($this->encryption->decrypt($this->input->cookie('sysp')), $permission)) {
            $arrposition = array(2, 3);
            $condition = array();
            $condition['fide'] = "*";
            $condition['where_in']['filde'] = 'position_id';
            $condition['where_in']['value'] = $arrposition;
            $data['user'] = $this->administrator->listData($condition);

            $data['formcrf'] = $this->tokens->token('formcrf');

            // edit form
            if (!empty($id)) {
                $condition = array();
                $condition['fide'] = "*";
                $condition['where'] = array('sub_id' => $id);
                $data['listdata'] = $this->subject->listData($condition);

                // show_404
                if (count($data['listdata']) == 0) {
                    show_404();
                    // show_404
                } elseif ($data['listdata'][0]['use_id'] != $this->encryption->decrypt($this->input->cookie('sysli')) || $this->encryption->decrypt($this->input->cookie('sysp')) != 'ผู้ดูแลระบบ') {
                    $this->load->view('errors/html/error_403');
                    // show edit form
                } else {
                    $this->template->backend('subject/form', $data);
                }
                // insert form
            } else {
                $this->template->backend('subject/form', $data);
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
                'url' => site_url('subject/index')
            );
            echo json_encode($result);
        }
    }

    public function updateclose($sub_id = "")
    {
        if($sub_id == ""){
            show_404();
        }else{
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
        if($sub_id == ""){
            show_404();
        }else{
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
