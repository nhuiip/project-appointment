<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Section extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("setting_model", "setting");
        $this->load->model("holiday_model", "holiday");
        $this->load->model("section_model", "section");
        $this->load->model("administrator_model", "administrator");
        $this->load->model("meet_model", "meet");
        $this->load->helper('fileexist');
    }

    public function timecheck($id = '')
    {
        if (!empty($id)) {
            $condition['fide'] = "sec_status";
            $condition['where'] = array('sec_id' => $id);
            $listsec = $this->section->listData($condition);
            if ($listsec[0]['sec_status'] == 0) {
                $sec_status = 1;
            } else {
                $sec_status = 0;
            }
            $data = array(
                'sec_id'            => $id,
                'sec_status'        => $sec_status
            );
            $this->section->updateData($data);
            header("location:" . site_url('profile/index/' . $this->encryption->decrypt($this->input->cookie('sysli'))));
        } else {
            show_404();
        }
    }

    // ว่างเช้า
    public function freeM($date = "", $use_id = "")
    {
        if (!empty($date) && !empty($use_id)) {
            $time = array('9.00', '10.00', '11.00');
            foreach ($time as $key => $value) {
                $condition['fide'] = "sec_id";
                $condition['where'] = array('use_id' => $use_id, 'sec_date' => $date, 'sec_time_one' => $value);
                $listsec = $this->section->listData($condition);
                if (count($listsec)) {
                    $data = array(
                        'sec_id'            => $listsec[0]['sec_id'],
                        'sec_status'        => 1,
                    );
                    $this->section->updateData($data);
                }
            }
            header("location:" . site_url('profile/index/' . $this->encryption->decrypt($this->input->cookie('sysli'))));
        } else {
            show_404();
        }
    }
    // ไม่ว่างเช้า
    public function busyM($date = "", $use_id = "")
    {
        if (!empty($date) && !empty($use_id)) {
            $time = array('9.00', '10.00', '11.00');
            foreach ($time as $key => $value) {
                $condition['fide'] = "sec_id, sec_status";
                $condition['where'] = array('use_id' => $use_id, 'sec_date' => $date, 'sec_time_one' => $value);
                $listsec = $this->section->listData($condition);
                if (count($listsec)) {
                    // ถ้ามีนัดแล้ว
                    if ($listsec[0]['sec_status'] == 2) { }
                    // $data = array(
                    //     'sec_id'            => $listsec[0]['sec_id'],
                    //     'sec_status'        => 1,
                    // );
                    // $this->section->updateData($data);
                }
            }
            header("location:" . site_url('profile/index/' . $this->encryption->decrypt($this->input->cookie('sysli'))));
        } else {
            show_404();
        }
    }

    // ว่างบ่าย
    public function freeA($date = "", $use_id = "")
    {
        if (!empty($date) && !empty($use_id)) {
            $time = array('13.00', '14.00', '15.00');
            foreach ($time as $key => $value) {
                $condition['fide'] = "sec_id";
                $condition['where'] = array('use_id' => $use_id, 'sec_date' => $date, 'sec_time_one' => $value);
                $listsec = $this->section->listData($condition);
                if (count($listsec)) {
                    $data = array(
                        'sec_id'            => $listsec[0]['sec_id'],
                        'sec_status'        => 1,
                    );
                    $this->section->updateData($data);
                }
            }
            header("location:" . site_url('profile/index/' . $this->encryption->decrypt($this->input->cookie('sysli'))));
        } else {
            show_404();
        }
    }
    // ไม่ว่างเช้า
    public function busyA($date = "", $use_id = "")
    {
        // die;
        if (!empty($date) && !empty($use_id)) {
            $time = array('13.00', '14.00', '15.00');
            foreach ($time as $key => $value) {
                $condition['fide'] = "sec_id, sec_status, sec_time_one, sec_time_two";
                $condition['where'] = array('use_id' => $use_id, 'sec_date' => $date, 'sec_time_one' => $value);
                $listsec = $this->section->listData($condition);
                if (count($listsec)) {
                    // ถ้ามีนัดแล้ว
                    if ($listsec[0]['sec_status'] == 2) {

                        $this->db->select("tb_meetdetail.meet_id");
                        $this->db->from('tb_meet');
                        $this->db->join('tb_meetdetail', 'tb_meetdetail.meet_id = tb_meet.meet_id');
                        $this->db->where('tb_meetdetail.use_id', $use_id);
                        $this->db->where('meet_date', $date);
                        $this->db->where("(tb_meet.meet_time=" . $listsec[0]['sec_time_one'] . "OR tb_meet.meet_time=" . $listsec[0]['sec_time_two'] . ")", NULL, FALSE);
                        $query = $this->db->get();
                        $meetdetail = $query->result_array();

                        echo '<pre>';
                        print_r($meetdetail);
                        echo '</pre>';
                    }
                }
            }

            // header("location:" . site_url('profile/index/' . $this->encryption->decrypt($this->input->cookie('sysli'))));
        } else {
            show_404();
        }
    }

    // ว่างบ่าย
    public function freeAllday($date = "", $use_id = "")
    {
        if (!empty($date) && !empty($use_id)) {
            $condition['fide'] = "sec_id";
            $condition['where'] = array('use_id' => $use_id, 'sec_date' => $date);
            $listsec = $this->section->listData($condition);
            if (count($listsec)) {
                foreach ($listsec as $key => $value) {
                    $data = array(
                        'sec_id'            => $value['sec_id'],
                        'sec_status'        => 1,
                    );
                    $this->section->updateData($data);
                }
            }
            header("location:" . site_url('profile/index/' . $this->encryption->decrypt($this->input->cookie('sysli'))));
        } else {
            show_404();
        }
    }
}
