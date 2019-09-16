<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Holiday extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("holiday_model", "holiday");
        $this->load->helper('fileexist');
    }
    public function index()
    {
        $data = array();
        $condition = array();
        $condition['fide'] = "*";
        $condition['where'] = array('hol_delete_status' => 1);
        $condition['orderby'] = "set_id DESC  ";
        $data['listdata'] = $this->holiday->listData($condition);

        $this->template->backend('setting/main', $data);
    }
}