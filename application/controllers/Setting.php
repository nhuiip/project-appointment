<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setting extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("setting_model", "setting");
        $this->load->model("holiday_model", "holiday");
        $this->load->model("section_model", "section");
        $this->load->model("administrator_model", "administrator");
        $this->load->helper('fileexist');
    }

    public function index()
    {
        $permission = array("ผู้ดูแลระบบ");
        if (in_array($this->encryption->decrypt($this->input->cookie('sysp')), $permission)) {
            $data = array();
            $condition = array();
            $condition['fide'] = "*";
            $condition['orderby'] = "set_status DESC  ";
            $data['listdata'] = $this->setting->listData($condition);

            $condition = array();
            $condition['fide'] = "set_status";
            $condition['where'] = array('set_status !=' => 0);
            $checkinsert = $this->setting->listData($condition);

            if (count($checkinsert) != 0) {
                $data['checkinsert'] = 'no';
            } else {
                $data['checkinsert'] = 'yes';
            }
            $data['formcrf'] = $this->tokens->token('formcrf');
            $this->template->backend('setting/main', $data);
        } else {
            $this->load->view('errors/html/error_403');
        }
    }
    public function form($id = "")
    {
        $permission = array("ผู้ดูแลระบบ");
        if (in_array($this->encryption->decrypt($this->input->cookie('sysp')), $permission)) {
            if (!empty($id)) {
                $condition = array();
                $condition['fide'] = "*";
                $condition['where'] = array('set_id' => $id);
                $data['listdata'] = $this->setting->listData($condition);

                $condition = array();
                $condition['fide'] = "*";
                $condition['where'] = array('set_id' => $id);
                $condition['orderby'] = "hol_date ASC  ";
                $data['listholiday'] = $this->holiday->listData($condition);

                if (count($data['listdata']) == 0) {
                    show_404();
                }
            }
            $data['formcrf'] = $this->tokens->token('formcrf');
            $this->template->backend('setting/form', $data);
        } else {
            $this->load->view('errors/html/error_403');
        }
    }
    public function create()
    {
        if ($this->tokens->verify('formcrf')) {
            if ($this->input->post('set_option_sat') != '') {
                $set_option_sat = 1;
            } else {
                $set_option_sat = 0;
            }
            if ($this->input->post('set_option_sun') != '') {
                $set_option_sun = 1;
            } else {
                $set_option_sun = 0;
            }
            $data = array(
                'set_year'          => $this->input->post('set_year'),
                'set_term'          => $this->input->post('set_term'),
                'set_open'          => $this->input->post('set_open'),
                'set_close'         => $this->input->post('set_close'),
                'set_option_sat'    => $set_option_sat,
                'set_option_sun'    => $set_option_sun,
                'set_status'        => 1,
                'set_create_name'   => $this->encryption->decrypt($this->input->cookie('sysn')),
                'set_create_date'   => date('Y-m-d H:i:s'),
                'set_lastedit_name' => $this->encryption->decrypt($this->input->cookie('sysn')),
                'set_lastedit_date' => date('Y-m-d H:i:s'),
            );
            $this->setting->insertData($data);
            $result = array(
                'error' => false,
                'msg' => 'เพิ่มข้อมูลสำเร็จ',
                'url' => site_url('setting/index')
            );
            echo json_encode($result);
        }
    }
    public function update()
    {
        if ($this->tokens->verify('formcrf')) {
            if ($this->input->post('set_option_sat') != '') {
                $set_option_sat = 1;
            } else {
                $set_option_sat = 0;
            }
            if ($this->input->post('set_option_sun') != '') {
                $set_option_sun = 1;
            } else {
                $set_option_sun = 0;
            }
            $data = array(
                'set_id'            => $this->input->post('Id'),
                'set_year'          => $this->input->post('set_year'),
                'set_term'          => $this->input->post('set_term'),
                'set_open'          => $this->input->post('set_open'),
                'set_close'         => $this->input->post('set_close'),
                'set_option_sat'    => $set_option_sat,
                'set_option_sun'    => $set_option_sun,
                'set_lastedit_name' => $this->encryption->decrypt($this->input->cookie('sysn')),
                'set_lastedit_date' => date('Y-m-d H:i:s'),
            );
            $this->setting->updateData($data);
            $result = array(
                'error' => false,
                'msg' => 'แก้ไขข้อมูลสำเร็จ',
                'url' => site_url('setting/index')
            );
            echo json_encode($result);
        }
    }
    // public function delete($id = '')
    // {
    //     $data = array(
    //         'set_id'            => $id,
    //         'set_lastedit_name' => $this->encryption->decrypt($this->input->cookie('sysn')),
    //         'set_lastedit_date' => date('Y-m-d H:i:s'),
    //     );
    //     $this->setting->updateData($data);
    //     header("location:" . site_url('setting/index'));
    // }
    public function createHol()
    {
        if ($this->tokens->verify('formcrf')) {
            $data = array(
                'hol_name'          => $this->input->post('hol_name'),
                'hol_date'          => $this->input->post('hol_date'),
                'set_id'            => $this->input->post('Id'),
                'hol_create_name'   => $this->encryption->decrypt($this->input->cookie('sysn')),
                'hol_create_date'   => date('Y-m-d H:i:s'),
                'hol_lastedit_name' => $this->encryption->decrypt($this->input->cookie('sysn')),
                'hol_lastedit_date' => date('Y-m-d H:i:s'),
            );
            $this->holiday->insertData($data);
            $result = array(
                'error' => false,
                'msg' => 'เพิ่มข้อมูลสำเร็จ',
                'url' => site_url('setting/form/2/' . $this->input->post('Id'))
            );
            echo json_encode($result);
        }
    }
    public function updateHol()
    {
        if ($this->tokens->verify('formcrf')) {
            $data = array(
                'hol_id'            => $this->input->post('hol_id'),
                'hol_name'          => $this->input->post('hol_name'),
                'hol_date'          => $this->input->post('hol_date'),
                'set_id'            => $this->input->post('Id'),
                'hol_lastedit_name' => $this->encryption->decrypt($this->input->cookie('sysn')),
                'hol_lastedit_date' => date('Y-m-d H:i:s'),
            );
            $this->holiday->updateData($data);
            $result = array(
                'error' => false,
                'msg' => 'แก้ไขข้อมูลสำเร็จ',
                'url' => site_url('setting/form/2/' . $this->input->post('Id'))
            );
            echo json_encode($result);
        }
    }
    // public function deleteHol($set_id, $id = '')
    // {
    //     $data = array(
    //         'hol_id'            => $id,
    //         'hol_lastedit_name' => $this->encryption->decrypt($this->input->cookie('sysn')),
    //         'hol_lastedit_date' => date('Y-m-d H:i:s'),
    //     );
    //     $this->holiday->updateData($data);
    //     header("location:" . site_url('setting/form/2/' . $set_id));
    // }
    public function opensection($id = '')
    {
        if (!empty($id)) {
            $condition = array();
            $condition['fide'] = "*";
            $condition['where'] = array('set_id' => $id);
            $setting = $this->setting->listData($condition);

            $condition = array();
            $condition['fide'] = "hol_date";
            $condition['where'] = array('set_id' => $id);
            $holiday = $this->holiday->listData($condition);

            $arrposition = array(2, 3);
            $condition = array();
            $condition['fide'] = "use_id";
            $condition['where_in']['filde'] = 'position_id';
            $condition['where_in']['value'] = $arrposition;
            $user = $this->administrator->listData($condition);

            if (count($setting) == 0) {
                show_404();
            }
        }
        // หาช่วงวันที่
        $perday = new DatePeriod(
            new DateTime($setting[0]['set_open']),
            new DateInterval('P1D'),
            new DateTime($setting[0]['set_close'])
        );
        //วันหยุด
        $arrholiday = array();
        foreach ($holiday as $key => $value) {
            array_push($arrholiday, $value['hol_date']);
        }

        $date = array();
        //ตัดวันเสาร์อาทิตย์
        if ($setting[0]['set_option_sat'] == 0 && $setting[0]['set_option_sun'] == 0) {
            foreach ($perday as $key => $value) {
                $thisdate = $value->format('Y-m-d');
                if ((date('w', strtotime($thisdate)) != 6 && date('w', strtotime($thisdate)) != 0) && !in_array($thisdate, $arrholiday)) {
                    array_push($date, $thisdate);
                }
            }
        }
        //ตัดวันอาทิตย์
        if ($setting[0]['set_option_sat'] == 1 && $setting[0]['set_option_sun'] == 0) {
            foreach ($perday as $key => $value) {
                $thisdate = $value->format('Y-m-d');
                if (date('w', strtotime($thisdate)) != 0 && !in_array($thisdate, $arrholiday)) {
                    array_push($date, $thisdate);
                }
            }
        }
        //ตัดวันเสาร์
        if ($setting[0]['set_option_sat'] == 0 && $setting[0]['set_option_sun'] == 1) {
            foreach ($perday as $key => $value) {
                $thisdate = $value->format('Y-m-d');
                if (date('w', strtotime($thisdate)) != 6 && !in_array($thisdate, $arrholiday)) {
                    array_push($date, $thisdate);
                }
            }
        }
        //เปิดนัดทุกวัน
        if ($setting[0]['set_option_sat'] == 0 && $setting[0]['set_option_sun'] == 1) {
            foreach ($perday as $key => $value) {
                $thisdate = $value->format('Y-m-d');
                array_push($date, $thisdate);
            }
        }

        //insert section
        foreach ($user as $key => $value) {
            $use_id = $value['use_id'];
            foreach ($date as $key => $value) {
                $data = array(
                    'sec_date'          => $value,
                    'sec_one'           => '9.00, 9.00, 1, sec_one',
                    'sec_two'           => '10.00, 10.30, 1, sec_two',
                    'sec_three'         => '11.00, 12.00, 1, sec_three',
                    'sec_four'          => '13.00, 13.00, 1, sec_four',
                    'sec_five'          => '14.00, 14.30, 1, sec_five',
                    'sec_six'           => '15.00, 16.00, 1, sec_six',
                    'use_id'            => $use_id,
                    'set_id'            => $id,
                    'sec_create_name'   => $this->encryption->decrypt($this->input->cookie('sysn')),
                    'sec_create_date'   => date('Y-m-d H:i:s'),
                    'sec_lastedit_name' => $this->encryption->decrypt($this->input->cookie('sysn')),
                    'sec_lastedit_date' => date('Y-m-d H:i:s'),
                );
                $this->section->insertData($data);
            }
        }
        $data = array(
            'set_id'            => $id,
            'set_status'        => 2,
        );
        $this->setting->updateData($data);
    }
}
