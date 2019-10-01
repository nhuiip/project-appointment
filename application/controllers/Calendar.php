<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Calendar extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("project_model", "project");
        $this->load->model("student_model", "student");
        $this->load->model("subject_model", "subject");
        $this->load->model("setting_model", "setting");
        $this->load->model("section_model", "section");
    }

    public function index($id = "")
    {
        $poslogin   = $this->encryption->decrypt($this->input->cookie('sysp'));
        $idlogin    = $this->encryption->decrypt($this->input->cookie('sysli'));

        if (!empty($this->encryption->decrypt($this->input->cookie('syslev')))) {
            if ($id == "") {
                show_404();
            } elseif ($poslogin == 'นักศึกษา' && $idlogin == $id) {

                $condition = array();
                $condition['fide'] = "std_id";
                $condition['where'] = array('std_id' => $id);
                $checkstudent = $this->student->listData($condition);
                if (count($checkstudent) == 0) {
                    show_404();
                } else {

                    $data = array();


                    $data['formcrf'] = $this->tokens->token('formcrf');

                    $this->template->backend('calendar/main', $data);
                }
            } else {
                show_404();
            }
        }
    }

    public function jsoneven()
    {
        $condition = array();
        $burl = site_url('calendar/detail/');
        $condition['fide'] = "*";
        $condition['where'] = array('set_status' => 2);
        $data['listdata'] = $this->setting->listData($condition);

        $condition['fide'] = "*";
        $condition['where'] = array('set_id' => $data['listdata'][0]['set_id']);
        // $condition['where'] = array('set_id ' => 5);
        $condition['groupby'] = "sec_date";
        $data['listsec'] = $this->section->listData($condition);

        // echo "<pre>";
        // print_r($data['listsec']);
        // echo "</pre>";
        // die;

        if (count($data['listdata']) != 0) {
            $listJson = array();

            foreach ($data['listsec'] as $key => $value) {
                $listJson[$key]['title'] = "นัดสอบ";
                $listJson[$key]['start'] = $value['sec_date'];
                $listJson[$key]['color'] = "#e67e22";
            }
        }
        echo json_encode($listJson);
    }
}
