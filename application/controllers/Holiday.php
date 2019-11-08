<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Holiday extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("holiday_model", "holiday");
        $this->load->model("setting_model", "setting");
        $this->load->helper('fileexist');
    }
    public function index($id = "")
    {
        $permission = array("ผู้ดูแลระบบ");
        if (in_array($this->encryption->decrypt($this->input->cookie('sysp')), $permission)) {
            if (!empty($id)) {
                $data = array();

                $condition = array();
                $condition['fide'] = "*";
                $condition['where'] = array('set_id' => $id);
                $condition['orderby'] = "hol_date ASC  ";
                $data['listholiday'] = $this->holiday->listData($condition);

                $data['set_id'] = $id;
                $data['formcrf'] = $this->tokens->token('formcrf');
                $this->template->backend('setting/holiday', $data);
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
                'hol_name'          => $this->input->post('hol_name'),
                'hol_date'          => $this->input->post('hol_date'),
                'set_id'            => $this->input->post('set_id'),
                'hol_create_name'   => $this->encryption->decrypt($this->input->cookie('sysn')),
                'hol_create_date'   => date('Y-m-d H:i:s'),
                'hol_lastedit_name' => $this->encryption->decrypt($this->input->cookie('sysn')),
                'hol_lastedit_date' => date('Y-m-d H:i:s'),
            );
            $this->holiday->insertData($data);
            $result = array(
                'error' => false,
                'msg' => 'เพิ่มข้อมูลสำเร็จ',
                'url' => site_url('holiday/index/' . $this->input->post('set_id'))
            );
            echo json_encode($result);
        }
    }

    public function update()
    {
        if ($this->tokens->verify('formcrf')) {
            $data = array(
                'hol_id'            => $this->input->post('hol_id'),
                'hol_name'          => $this->input->post('hol_name'),
                'hol_date'          => $this->input->post('hol_date'),
                'hol_lastedit_name' => $this->encryption->decrypt($this->input->cookie('sysn')),
                'hol_lastedit_date' => date('Y-m-d H:i:s'),
            );
            $this->holiday->updateData($data);
            $result = array(
                'error' => false,
                'msg' => 'แก้ไขข้อมูลสำเร็จ',
                'url' => site_url('holiday/index/' . $this->input->post('set_id'))
            );
            echo json_encode($result);
        }
    }

    public function delete($set_id, $id = '')
    {
        $data = array(
            'hol_id'            => $id,
        );
        $this->holiday->deleteData($data);
        header("location:" . site_url('holiday/index/' . $set_id));
    }

    public function checkdate()
    {
        $set_id = $this->input->post('set_id');
        $hol_date = $this->input->post('hol_date');
        $condition = array();
        $condition['fide'] = "set_open, set_close";
        $condition['where'] = array('set_id' => $set_id);
        $listdata = $this->setting->listData($condition);

        if (count($listdata) == 1) {
            $begin = new DateTime($listdata[0]['set_open']);
            $end = clone $begin;
            $end->modify($listdata[0]['set_close']);
            $end->setTime(0, 0, 1);
            $interval = new DateInterval('P1D');
            $daterange = new DatePeriod($begin, $interval, $end);

            $valdate = array();
            foreach ($daterange as $key => $value) {
                $valdate[$key] = $value->format('Y-m-d');
            }
            if (in_array($hol_date, $valdate)) {
                echo "true";
            } else {
                echo "false";
            }
        }
    }
}
