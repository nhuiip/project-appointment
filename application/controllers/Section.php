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
        $this->load->helper('fileexist');
    }

    public function timecheck($id = '')
    {
        // echo $id;
        // die;
        if(!empty($id)){
            $condition['fide'] = "*";
            $condition['where'] = array('sec_id' => $id);
            $listsec = $this->section->listData($condition);
            if($listsec[0]['sec_status'] == 0){
                $sec_status = 1;
            } else {
                $sec_status = 0;
            }
            $data = array(
                'sec_id'            => $id,
                'sec_status'        => $sec_status
            );
            $this->section->updateData($data);
            header("location:" . site_url('profile/index/'.$this->encryption->decrypt($this->input->cookie('sysli'))));
        } else {
            show_404();
        }
        
    }
}
