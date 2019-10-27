<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Subject extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("conference_model", "conference");
    }

    // conference
    public function insertData()
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

    public function updateData()
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

    public function deleteData($id = '')
    {
        $data = array(
            'sub_id'            => $id,
        );
        $this->subject->deleteData($data);
        header("location:" . site_url('subject/index'));
    }

    // conference person
    public function insertPerson()
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
            $this->subject->insertPerson($data);
            $result = array(
                'error' => false,
                'msg' => 'เพิ่มข้อมูลสำเร็จ',
                'url' => site_url('subject/index')
            );
            echo json_encode($result);
        }
    }

    public function updatePerson()
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
            $this->subject->updatePerson($data);
            $result = array(
                'error' => false,
                'msg' => 'แก้ไขข้อมูลสำเร็จ',
                'url' => site_url('subject/index')
            );
            echo json_encode($result);
        }
    }

    public function deletePerson($id = '')
    {
        $data = array(
            'sub_id'            => $id,
        );
        $this->subject->deletePerson($data);
        header("location:" . site_url('subject/index'));
    }
}
