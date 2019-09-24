<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Student extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("student_model", "student");
        $this->load->model("subject_model", "subject");
        $this->load->model("setting_model", "setting");
    }

    public function register()
    {
        $data = array();

        $condition = array();
        $condition['fide'] = "*";
        $condition['where'] = array('set_status' => 2);
        $listset = $this->setting->listData($condition);
        // echo count($listset);
        // die;
        if (count($listset) != 1) {
            $this->load->view('page/noreg');
        } else {
            $condition = array();
            $condition['fide'] = "*";
            $condition['orderby'] = "tb_settings.set_status DESC, tb_subject.sub_id DESC ";
            $data['listdata'] = $this->subject->listjoinData($condition);

            $condition = array();
            $condition['fide'] = "sub_id, sub_name";
            $condition['where'] = array('set_id' =>  $listset[0]['set_id']);
            $condition['orderby'] = "sub_id DESC ";
            $data['subject'] = $this->subject->listData($condition);

            // echo '<pre>';
            // print_r($data['listsubject']);
            // echo '</pre>';
            // die;

            $data['formcrf'] = $this->tokens->token('formcrf');
            $this->load->view('page/register', $data);
        }
    }

    public function create()
    {
    
        echo $this->input->post('std_img');
        die;
        if ($this->tokens->verify('formcrf')) {
            $data = array(
                'sub_id'            => $this->input->post('sub_id'),
                'std_img'           => $this->input->post('std_number') . '.png',
                'std_number'        => $this->input->post('std_number'),
                'std_title'         => $this->input->post('std_title'),
                'std_fname'         => $this->input->post('std_fname'),
                'std_lname'         => $this->input->post('std_lname'),
                'std_email'         => $this->input->post('std_email'),
                'std_pass'          => md5($this->input->post('std_pass')),
                'std_tel'           => $this->input->post('std_tel'),
                'std_checkmail'     => 0,
                'std_status'     => 0,
                'std_create_name'   => $this->encryption->decrypt($this->input->cookie('sysn')),
                'std_create_date'   => date('Y-m-d H:i:s'),
                'std_lastedit_name' => $this->encryption->decrypt($this->input->cookie('sysn')),
                'std_lastedit_date' => date('Y-m-d H:i:s'),
            );
            $this->student->insertData($data);

            define('UPLOAD_DIR', './uploads/student/');
            $img = $this->input->post('std_img');
            $img = str_replace('data:image/jpeg;base64,', '', $img);
            $img = str_replace('data:image/jpg;base64,', '', $img);
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            $file = UPLOAD_DIR  . $this->input->post('std_number') .'.png';
            file_put_contents($file, $data);

            $result = array(
                'error' => false,
                'msg' => 'เพิ่มข้อมูลสำเร็จ',
                'url' => site_url('subject/index')
            );
            echo json_encode($result);
        }
    }

    private function upfileimages($Fild_Name)
    {
        if (!empty($_FILES[$Fild_Name])) {
            $new_name = time();
            $config['upload_path'] = './uploads/student';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['file_name'] = $new_name;
            $config['max_size']    = '6500';
            $this->load->library('upload', $config, 'upbanner');
            $this->upbanner->initialize($config);
            if (!$this->upbanner->do_upload($Fild_Name)) {
                $result = array(
                    'error' => true,
                    'title' => "Error",
                    'msg' => $this->upbanner->display_errors()
                );
                echo json_encode($result);
                die;
            } else {
                $img = $this->upbanner->data();
                return $img['file_name'];
            }
        }
    }


    // ===============================================



}
