<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Amcalendar extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("project_model", "project");
        $this->load->model("student_model", "student");
        $this->load->model("subject_model", "subject");
        $this->load->model("setting_model", "setting");
        $this->load->model("section_model", "section");
        $this->load->model("meet_model", "meet");
        $this->load->model("administrator_model", "administrator");
        $this->load->library('cart');
        $this->load->library('session');
    }

    public function index()
    {
        $poslogin   = $this->encryption->decrypt($this->input->cookie('sysp'));
        $idlogin    = $this->encryption->decrypt($this->input->cookie('sysli'));

        if (!empty($this->encryption->decrypt($this->input->cookie('syslev')))) {
            $data = array();

            $condition['fide'] = "*";
            $condition['where'] = array('tb_settings.set_status' => 2);
            $condition['groupby'] = "sec_date";
            $data['listsec'] = $this->section->listjoinData($condition);
            
            $time = array();
            $time[0] = array('one' => '9.00', 'two' => '9.00');
            $time[1] = array('one' => '10.00', 'two' => '10.30');
            $time[2] = array('one' => '11.00', 'two' => '12.00');
            $time[3] = array('one' => '13.00', 'two' => '13.00');
            $time[4] = array('one' => '14.00', 'two' => '14.30');
            $time[5] = array('one' => '15.00', 'two' => '16.00');

            $data['time'] = $time;
            $this->template->backend('calendar/adminmain', $data);
        } else {
            show_404();
        }
    }
}
